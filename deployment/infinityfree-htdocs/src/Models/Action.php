<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Actions / Campagnes de l'ONG
 */
class Action extends Model
{
    protected string $table = 'actions';

    /**
     * Récupère les actions avec informations de zone et pourcentage collecté
     */
    public function getWithDetails(?string $status = null, int $limit = 50): array
    {
        $sql = "
            SELECT a.*, 
                   z.nom AS zone_nom, z.pays AS zone_pays, z.ville AS zone_ville,
                   ROUND(IF(a.objectif_financier > 0, (a.montant_collecte / a.objectif_financier) * 100, 0), 1) AS pourcentage_collecte
            FROM actions a
            LEFT JOIN zones z ON z.id = a.zone_id
        ";

        $params = [];
        if ($status !== null) {
            $sql .= " WHERE a.statut = :statut";
            $params['statut'] = $status;
        }

        $sql .= " ORDER BY a.id DESC LIMIT {$limit}";

        return $this->rawQuery($sql, $params);
    }

    /**
     * Récupère une action complète avec ses photos et ses bénéficiaires
     */
    public function getFullDetails(int $id): ?array
    {
        $action = $this->find($id);
        if (!$action) {
            return null;
        }

        // Zone associée
        if (!empty($action['zone_id'])) {
            $stmt = $this->db->prepare("SELECT * FROM zones WHERE id = :id");
            $stmt->execute(['id' => $action['zone_id']]);
            $action['zone'] = $stmt->fetch() ?: null;
        } else {
            $action['zone'] = null;
        }

        // Calcul du pourcentage
        $action['pourcentage_collecte'] = $action['objectif_financier'] > 0
            ? min(100, round(($action['montant_collecte'] / $action['objectif_financier']) * 100, 1))
            : 0;

        // Photos avant / après (Innovation 7)
        $photoStmt = $this->db->prepare("SELECT * FROM action_photos WHERE action_id = :id ORDER BY id ASC");
        $photoStmt->execute(['id' => $id]);
        $action['photos'] = $photoStmt->fetchAll();

        // Bénéficiaires associés
        $benStmt = $this->db->prepare("
            SELECT b.* 
            FROM beneficiaires b
            JOIN action_beneficiaires ab ON ab.beneficiaire_id = b.id
            WHERE ab.action_id = :id
        ");
        $benStmt->execute(['id' => $id]);
        $action['beneficiaires'] = $benStmt->fetchAll();

        // Rapport d'impact (s'il existe)
        $rapportStmt = $this->db->prepare("SELECT * FROM rapports_impact WHERE action_id = :id LIMIT 1");
        $rapportStmt->execute(['id' => $id]);
        $action['rapport_impact'] = $rapportStmt->fetch() ?: null;

        return $action;
    }

    /**
     * Met à jour le montant collecté dénormalisé d'une action
     */
    public function refreshMontantCollecte(int $actionId): void
    {
        $sql = "
            UPDATE actions a
            SET a.montant_collecte = (
                SELECT COALESCE(SUM(d.montant), 0)
                FROM dons d
                JOIN transactions t ON t.don_id = d.id
                WHERE d.action_id = a.id AND t.statut = 'confirme'
            )
            WHERE a.id = :id
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $actionId]);
    }

    /**
     * Récupère la performance globale des actions sans dépendre d'une vue SQL.
     */
    public function getPerformanceStats(): array
    {
        return $this->rawQuery("
            SELECT a.id AS action_id, a.titre, a.objectif_financier,
                   COALESCE(SUM(CASE WHEN t.statut = 'confirme' THEN d.montant ELSE 0 END), 0) AS montant_collecte_reel,
                   COUNT(DISTINCT CASE WHEN t.statut = 'confirme' THEN d.donateur_id END) AS nombre_donateurs,
                   ROUND(COALESCE(SUM(CASE WHEN t.statut = 'confirme' THEN d.montant ELSE 0 END) / NULLIF(a.objectif_financier, 0) * 100, 0), 2) AS pourcentage_atteint
            FROM actions a
            LEFT JOIN dons d ON d.action_id = a.id
            LEFT JOIN transactions t ON t.don_id = d.id
            GROUP BY a.id, a.titre, a.objectif_financier
            ORDER BY pourcentage_atteint DESC
        ");
    }
}
