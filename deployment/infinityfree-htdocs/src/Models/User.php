<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle Utilisateur du CRM
 */
class User extends Model
{
    protected string $table = 'utilisateurs';

    /**
     * Récupère tous les utilisateurs avec le nom de leur rôle
     */
    public function getAllWithRoles(): array
    {
        $sql = "
            SELECT u.id, u.nom, u.prenom, u.email, u.telephone, u.statut, u.date_creation, u.derniere_connexion,
                   r.id AS role_id, r.nom AS role_nom, r.description AS role_description
            FROM utilisateurs u
            JOIN roles r ON r.id = u.role_id
            ORDER BY u.id ASC
        ";
        return $this->rawQuery($sql);
    }

    /**
     * Recherche un utilisateur par email
     */
    public function findByEmail(string $email): ?array
    {
        return $this->findFirst(['email' => $email]);
    }

    /**
     * Crée un utilisateur avec mot de passe haché
     */
    public function registerUser(array $data): int
    {
        if (isset($data['mot_de_passe'])) {
            $data['mot_de_passe_hash'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
            unset($data['mot_de_passe']);
        }
        return $this->create($data);
    }

    /**
     * Met à jour le mot de passe
     */
    public function updatePassword(int $userId, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['mot_de_passe_hash' => $hash]);
    }

    /**
     * Liste tous les rôles disponibles
     */
    public function getRoles(): array
    {
        $stmt = $this->db->query("SELECT * FROM roles ORDER BY id ASC");
        return $stmt->fetchAll();
    }
}
