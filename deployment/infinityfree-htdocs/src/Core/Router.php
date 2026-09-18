<?php

namespace App\Core;

/**
 * Routeur HTTP supportant les méthodes GET, POST et les paramètres dynamiques {id}
 */
class Router
{
    private array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Enregistre une route GET
     */
    public function get(string $path, array|callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * Enregistre une route POST
     */
    public function post(string $path, array|callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * Ajoute une route à la table interne
     */
    private function addRoute(string $method, string $path, array|callable $handler): void
    {
        $path = rtrim($path, '/');
        $path = empty($path) ? '/' : $path;

        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * Résout la requête en cours et appelle le contrôleur approprié
     */
    public function dispatch(): void
    {
        $requestMethod = $this->request->getMethod();
        $requestPath = $this->request->getPath();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = $this->convertPathToRegex($route['path'], $paramNames);

            if (preg_match($pattern, $requestPath, $matches)) {
                $params = [];
                foreach ($paramNames as $name) {
                    if (isset($matches[$name])) {
                        $params[$name] = $matches[$name];
                    }
                }

                $this->request->setParams($params);

                $handler = $route['handler'];

                if (is_callable($handler)) {
                    call_user_func($handler, $this->request);
                    return;
                }

                if (is_array($handler) && count($handler) === 2) {
                    [$controllerClass, $actionMethod] = $handler;

                    if (!class_exists($controllerClass)) {
                        Response::notFound("Contrôleur [{$controllerClass}] introuvable.");
                    }

                    $controller = new $controllerClass();

                    if (!method_exists($controller, $actionMethod)) {
                        Response::notFound("Méthode [{$actionMethod}] introuvable dans [{$controllerClass}].");
                    }

                    $controller->$actionMethod($this->request);
                    return;
                }
            }
        }

        Response::notFound("La page demandée n'existe pas : [{$requestMethod} {$requestPath}]");
    }

    /**
     * Convertit un chemin avec paramètres {param} en expression régulière
     */
    private function convertPathToRegex(string $routePath, ?array &$paramNames = []): string
    {
        $paramNames = [];

        $pattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)\}/', function ($matches) use (&$paramNames) {
            $paramNames[] = $matches[1];
            return '(?P<' . $matches[1] . '>[^/]+)';
        }, $routePath);

        return '#^' . $pattern . '$#';
    }
}
