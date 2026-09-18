<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Zones géographiques (Innovation 4: Carte interactive)
 */
class Zone extends Model
{
    protected string $table = 'zones';

    /**
     * Récupère toutes les zones avec leurs actions associées pour la carte interactive
     */
    public function getWithActions(): array
    {
        $zones = $this->all('nom ASC');

        foreach ($zones as &$zone) {
            $stmt = $this->db->prepare("
                SELECT id, titre, statut, montant_collecte, objectif_financier 
                FROM actions 
                WHERE zone_id = :zone_id
            ");
            $stmt->execute(['zone_id' => $zone['id']]);
            $zone['actions'] = $stmt->fetchAll();

            // Comptage des bénéficiaires dans cette zone
            $bStmt = $this->db->prepare("SELECT COUNT(*) FROM beneficiaires WHERE zone_id = :zone_id");
            $bStmt->execute(['zone_id' => $zone['id']]);
            $zone['total_beneficiaires'] = (int)$bStmt->fetchColumn();
        }

        return $zones;
    }
}
