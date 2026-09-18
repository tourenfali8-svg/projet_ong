<?php

namespace App\Core;

use PDO;

/**
 * Gestionnaire d'authentification et de contrôle d'accès RBAC (Rôles & Permissions)
 */
class Auth
{
    private const SESSION_KEY = 'crm_auth_user';

    /**
     * Tente de connecter un utilisateur avec email et mot de passe
     */
    public static function attempt(string $email, string $password): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT u.*, r.nom AS role_nom
            FROM utilisateurs u
            JOIN roles r ON r.id = u.role_id
            WHERE u.email = :email AND u.statut = 'actif'
            LIMIT 1
        ");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe_hash'])) {
            // Mise à jour de la dernière connexion
            $updateStmt = $db->prepare("UPDATE utilisateurs SET derniere_connexion = NOW() WHERE id = :id");
            $updateStmt->execute(['id' => $user['id']]);

            // Stockage en session sans le hash du mot de passe
            unset($user['mot_de_passe_hash']);
            Session::set(self::SESSION_KEY, $user);
            return true;
        }

        return false;
    }

    /**
     * Vérifie si un utilisateur est connecté au CRM
     */
    public static function check(): bool
    {
        return Session::has(self::SESSION_KEY);
    }

    /**
     * Récupère l'utilisateur actuellement connecté
     */
    public static function user(): ?array
    {
        return Session::get(self::SESSION_KEY);
    }

    /**
     * Récupère l'identifiant de l'utilisateur connecté
     */
    public static function id(): ?int
    {
        $user = self::user();
        return $user ? (int)$user['id'] : null;
    }

    /**
     * Récupère le nom du rôle de l'utilisateur connecté
     */
    public static function role(): ?string
    {
        $user = self::user();
        return $user['role_nom'] ?? null;
    }

    /**
     * Vérifie si l'utilisateur possède l'un des rôles spécifiés
     * Exemple : Auth::hasRole('super_admin', 'gestionnaire_dons')
     */
    public static function hasRole(string ...$roles): bool
    {
        $currentRole = self::role();
        if (!$currentRole) {
            return false;
        }

        // Le super_admin a tous les droits
        if ($currentRole === 'super_admin') {
            return true;
        }

        return in_array($currentRole, $roles, true);
    }

    /**
     * Exige que l'utilisateur soit connecté, sinon redirige vers /admin/login
     */
    public static function requireAuth(): void
    {
        if (!self::check()) {
            Session::setFlash('warning', 'Veuillez vous connecter pour accéder à l\'espace d\'administration.');
            Response::redirect('/admin/login');
        }
    }

    /**
     * Exige que l'utilisateur possède un rôle spécifique
     */
    public static function requireRole(string ...$roles): void
    {
        self::requireAuth();

        if (!self::hasRole(...$roles)) {
            Session::setFlash('danger', 'Accès refusé : vous n\'avez pas les autorisations requises pour cette section.');
            Response::redirect('/admin/dashboard');
        }
    }

    /**
     * Déconnecte l'utilisateur
     */
    public static function logout(): void
    {
        Session::remove(self::SESSION_KEY);
    }
}
