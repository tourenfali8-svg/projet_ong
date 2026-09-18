<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Bénéficiaires de l'ONG
 */
class Beneficiary extends Model
{
    protected string $table = 'beneficiaires';

    /**
     * Récupère tous les bénéficiaires avec leur zone géographique
     */
    public function getAllWithZone(): array
    {
        $sql = "
            SELECT b.*, z.nom AS zone_nom, z.ville AS zone_ville, z.pays AS zone_pays,
                   COUNT(ab.action_id) AS total_actions
            FROM beneficiaires b
            LEFT JOIN zones z ON z.id = b.zone_id
            LEFT JOIN action_beneficiaires ab ON ab.beneficiaire_id = b.id
            GROUP BY b.id
            ORDER BY b.id DESC
        ";
        return $this->rawQuery($sql);
    }

    /**
     * Associe un bénéficiaire à une action
     */
    public function linkToAction(int $beneficiaryId, int $actionId): bool
    {
        $stmt = $this->db->prepare("
            INSERT IGNORE INTO action_beneficiaires (action_id, beneficiaire_id)
            VALUES (:action_id, :beneficiaire_id)
        ");
        return $stmt->execute([
            'action_id' => $actionId,
            'beneficiaire_id' => $beneficiaryId
        ]);
    }
}
