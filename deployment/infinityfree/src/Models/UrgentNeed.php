<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Besoins Urgents (Innovation 9)
 */
class UrgentNeed extends Model
{
    protected string $table = 'besoins_urgents';

    /**
     * Récupère les alertes urgentes actives avec détails de zone
     */
    public function getActiveUrgentNeeds(int $limit = 10): array
    {
        $sql = "
            SELECT bu.*, 
                   z.nom AS zone_nom, z.ville AS zone_ville, z.pays AS zone_pays,
                   a.titre AS action_associee_titre
            FROM besoins_urgents bu
            LEFT JOIN zones z ON z.id = bu.zone_id
            LEFT JOIN actions a ON a.id = bu.action_id
            WHERE bu.statut = 'actif'
            ORDER BY 
                CASE bu.niveau_urgence
                    WHEN 'critique' THEN 1
                    WHEN 'eleve' THEN 2
                    WHEN 'moyen' THEN 3
                    ELSE 4
                END,
                bu.id DESC
            LIMIT {$limit}
        ";
        return $this->rawQuery($sql);
    }
}
