<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Missions de Bénévolat
 */
class Mission extends Model
{
    protected string $table = 'missions_benevolat';

    /**
     * Récupère les missions ouvertes aux candidatures
     */
    public function getOpenMissions(): array
    {
        $sql = "
            SELECT m.*, a.titre AS action_titre
            FROM missions_benevolat m
            LEFT JOIN actions a ON a.id = m.action_id
            WHERE m.statut = 'ouverte'
            ORDER BY m.date_debut ASC
        ";
        return $this->rawQuery($sql);
    }
}
