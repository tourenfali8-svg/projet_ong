<?php

namespace App\Core;

/**
 * Gestionnaire de Session, Sécurité CSRF & Messages Flash
 */
class Session
{
    /**
     * Démarre la session de manière sécurisée
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_only_cookies', '1');
            ini_set('session.cookie_samesite', 'Lax');

            session_start();
        }

        // Initialisation du tableau des messages flash si absent
        if (!isset($_SESSION['_flash'])) {
            $_SESSION['_flash'] = [];
        }
    }

    /**
     * Stocke une valeur en session
     */
    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Récupère une valeur de session
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Vérifie si une clé existe en session
     */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Supprime une clé de la session
     */
    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Ajoute un message flash (accessible pour la prochaine requête)
     */
    public static function setFlash(string $type, string $message): void
    {
        self::start();
        $_SESSION['_flash'][$type][] = $message;
    }

    /**
     * Récupère et vide les messages flash d'un type ou tous les messages
     */
    public static function getFlashes(?string $type = null): array
    {
        self::start();

        if ($type !== null) {
            $messages = $_SESSION['_flash'][$type] ?? [];
            unset($_SESSION['_flash'][$type]);
            return $messages;
        }

        $all = $_SESSION['_flash'] ?? [];
        $_SESSION['_flash'] = [];
        return $all;
    }

    /**
     * Génère ou récupère le token CSRF courant
     */
    public static function csrfToken(): string
    {
        self::start();
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    /**
     * Valide le token CSRF fourni
     */
    public static function validateCsrf(?string $token): bool
    {
        self::start();
        if (empty($token) || empty($_SESSION['_csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['_csrf_token'], $token);
    }

    /**
     * Génère un champ input HTML caché contenant le token CSRF
     */
    public static function csrfField(): string
    {
        return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(self::csrfToken(), ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * Détruit complètement la session (déconnexion)
     */
    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }
}
