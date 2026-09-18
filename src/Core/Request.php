<?php

namespace App\Core;

/**
 * Abstraction et sécurisation de la requête HTTP
 */
class Request
{
    private array $params = [];

    /**
     * Méthode HTTP (GET, POST, PUT, DELETE, etc.)
     */
    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    /**
     * URI demandée nettoyée des paramètres d'URL (query string)
     */
    public function getPath(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($uri, '?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }

        // Supprime le slash terminal s'il ne s'agit pas de la racine
        $uri = rtrim($uri, '/');
        return empty($uri) ? '/' : $uri;
    }

    /**
     * Récupère un paramètre de requête GET
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Récupère un paramètre de formulaire POST
     */
    public function post(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Récupère l'ensemble des données du formulaire POST nettoyées
     */
    public function all(): array
    {
        $data = [];
        foreach ($_POST as $key => $value) {
            $data[$key] = is_string($value) ? trim($value) : $value;
        }
        return $data;
    }

    /**
     * Récupère le corps de la requête au format JSON
     */
    public function getJson(): array
    {
        $raw = file_get_contents('php://input');
        if (empty($raw)) {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Définit les paramètres d'URL extraits par le routeur (ex: /actions/{id})
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * Récupère un paramètre dynamique d'URL
     */
    public function param(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    /**
     * Vérifie si la requête est une requête AJAX / Fetch
     */
    public function isAjax(): bool
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));
    }
}
