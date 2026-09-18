<?php

namespace App\Core;

/**
 * Gestionnaire des réponses HTTP et JSON
 */
class Response
{
    /**
     * Définit le code de statut HTTP
     */
    public static function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * Effectue une redirection HTTP propre
     */
    public static function redirect(string $url, int $statusCode = 302): void
    {
        http_response_code($statusCode);
        header("Location: {$url}");
        exit;
    }

    /**
     * Envoie une réponse au format JSON
     */
    public static function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Envoie une réponse d'erreur 404
     */
    public static function notFound(string $message = 'Page non trouvée'): void
    {
        self::setStatusCode(404);
        echo "<!DOCTYPE html><html lang='fr'><head><meta charset='utf-8'><title>404 Non Trouvé</title>";
        echo "<style>body{font-family:sans-serif;text-align:center;padding:50px;}a{color:#007bff;}</style></head>";
        echo "<body><h1>Erreur 404</h1><p>" . htmlspecialchars($message) . "</p>";
        echo "<p><a href='/'>Retour à l'accueil</a></p></body></html>";
        exit;
    }
}
