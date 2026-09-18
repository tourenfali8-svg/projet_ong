<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Actualités / Articles de l'ONG
 */
class News extends Model
{
    protected string $table = 'actualites';

    /**
     * Récupère les actualités publiées pour le site public
     */
    public function getPublished(int $limit = 10): array
    {
        $sql = "
            SELECT act.*, 
                   a.titre AS action_titre,
                   CONCAT(u.prenom, ' ', u.nom) AS auteur_nom
            FROM actualites act
            LEFT JOIN actions a ON a.id = act.action_id
            LEFT JOIN utilisateurs u ON u.id = act.auteur_id
            WHERE act.statut = 'publie'
            ORDER BY act.date_publication DESC
            LIMIT {$limit}
        ";
        return $this->rawQuery($sql);
    }

    /**
     * Récupère toutes les actualités pour l'espace d'administration CRM
     */
    public function getAllForAdmin(): array
    {
        $sql = "
            SELECT act.*, 
                   a.titre AS action_titre,
                   CONCAT(u.prenom, ' ', u.nom) AS auteur_nom
            FROM actualites act
            LEFT JOIN actions a ON a.id = act.action_id
            LEFT JOIN utilisateurs u ON u.id = act.auteur_id
            ORDER BY act.id DESC
        ";
        return $this->rawQuery($sql);
    }
}
