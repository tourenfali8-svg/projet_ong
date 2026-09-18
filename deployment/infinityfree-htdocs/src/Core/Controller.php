<?php

namespace App\Core;

/**
 * Contrôleur de base fournissant les méthodes de rendu et de communication
 */
abstract class Controller
{
    protected string $defaultLayout = 'main';

    /**
     * Effectue le rendu d'une vue avec un gabarit (layout)
     */
    protected function render(string $viewPath, array $data = [], ?string $layout = null): void
    {
        $layoutName = $layout ?? $this->defaultLayout;

        // Extraction des variables transmises à la vue
        extract($data);

        // Variables globales toujours accessibles dans les vues
        $appConfig = require dirname(__DIR__, 2) . '/config/app.php';
        $currentUser = Auth::user();
        $flashes = Session::getFlashes();
        $csrfField = Session::csrfField();
        $csrfToken = Session::csrfToken();

        // Capture du contenu de la vue
        $viewFile = dirname(__DIR__, 2) . '/views/' . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($viewFile)) {
            Response::notFound("La vue [{$viewPath}] n'a pas été trouvée.");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Rendu dans le layout choisi (si un layout est défini)
        if ($layoutName !== null) {
            $layoutFile = dirname(__DIR__, 2) . '/views/layouts/' . $layoutName . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
                return;
            }
        }

        // Si aucun layout, afficher directement le contenu
        echo $content;
    }

    /**
     * Envoie une réponse JSON (utilisé pour les API et le chatbot)
     */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        Response::json($data, $statusCode);
    }

    /**
     * Redirige vers une URL avec option d'ajouter un message flash
     */
    protected function redirect(string $url, ?string $flashType = null, ?string $flashMessage = null): void
    {
        if ($flashType && $flashMessage) {
            Session::setFlash($flashType, $flashMessage);
        }
        Response::redirect($url);
    }

    /**
     * Redirige via une page HTML avec refresh, utile pour les liens externes et la compatibilité navigateur.
     */
    protected function redirectHtml(string $url): void
    {
        $escapedUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

        echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="0;url={$escapedUrl}">
    <title>Redirection vers WhatsApp</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f7fb;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }
        .redirect-box {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            padding: 32px 28px;
            text-align: center;
            max-width: 520px;
            width: calc(100% - 32px);
        }
        h1 {
            margin: 0 0 12px;
            font-size: 24px;
        }
        p {
            margin: 0 0 10px;
            line-height: 1.5;
        }
        a {
            color: #0b7bff;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="redirect-box">
        <h1>Redirection en cours...</h1>
        <p>Vous allez être redirigé vers WhatsApp.</p>
        <p><a href="{$escapedUrl}">Cliquez ici si la redirection ne se lance pas automatiquement.</a></p>
    </div>

    <script>
        try {
            window.location.replace('{$escapedUrl}');
        } catch (error) {
            window.location.href = '{$escapedUrl}';
        }
    </script>
</body>
</html>
HTML;
        exit;
    }

    /**
     * Vérifie le token CSRF pour les requêtes de formulaire
     */
    protected function validateCsrfToken(Request $request): void
    {
        $token = $request->post('_csrf') ?: ($request->getJson()['_csrf'] ?? null);
        if (!Session::validateCsrf($token)) {
            $this->redirect('/', 'danger', 'Session expirée ou requête non autorisée (échec CSRF).');
        }
    }
}
