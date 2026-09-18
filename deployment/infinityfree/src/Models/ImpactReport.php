<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Rapports d'Impact et KPI Publics (Innovation 7 & 12)
 */
class ImpactReport extends Model
{
    protected string $table = 'rapports_impact';

    /** Récupère les KPIs globaux sans dépendre d'une vue SQL. */
    public function getPublicImpactStats(): array
    {
        $stmt = $this->db->query("
            SELECT
                (SELECT COALESCE(SUM(nombre_beneficiaires_aides), 0) FROM rapports_impact) AS beneficiaires_aides,
                (SELECT COALESCE(SUM(d.montant), 0) FROM dons d JOIN transactions t ON t.don_id = d.id WHERE t.statut = 'confirme') AS fonds_collectes,
                (SELECT COUNT(*) FROM actions WHERE statut IN ('en_cours', 'terminee')) AS actions_realisees,
                (SELECT COUNT(DISTINCT zone_id) FROM actions WHERE zone_id IS NOT NULL) AS zones_couvertes,
                (SELECT COUNT(*) FROM actions WHERE statut = 'terminee') AS projets_termines
        ");
        $stats = $stmt->fetch();

        return $stats ?: [
            'beneficiaires_aides' => 0,
            'fonds_collectes' => 0,
            'actions_realisees' => 0,
            'zones_couvertes' => 0,
            'projets_termines' => 0
        ];
    }

    /**
     * Récupère tous les rapports d'impact publiés avec les informations de l'action
     */
    public function getAllPublishedReports(): array
    {
        $sql = "
            SELECT ri.*, a.titre AS action_titre, a.image AS action_image, a.date_debut, a.date_fin,
                   z.nom AS zone_nom, z.ville AS zone_ville
            FROM rapports_impact ri
            JOIN actions a ON a.id = ri.action_id
            LEFT JOIN zones z ON z.id = a.zone_id
            ORDER BY ri.date_publication DESC
        ";
        return $this->rawQuery($sql);
    }
}
