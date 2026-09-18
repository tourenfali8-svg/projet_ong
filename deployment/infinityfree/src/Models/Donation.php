<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Dons et Dons Récurrents
 */
class Donation extends Model
{
    protected string $table = 'dons';

    /**
     * Récupère tous les dons avec détails donateur, action et transaction
     */
    public function getAllWithDetails(int $limit = 100, ?string $statut = null): array
    {
        $sql = "
            SELECT d.*, 
                   dt.nom AS donateur_nom, dt.prenom AS donateur_prenom, dt.telephone AS donateur_telephone, dt.email AS donateur_email,
                   a.titre AS action_titre,
                   t.id AS transaction_id, t.operateur_paiement, t.reference_transaction, t.statut AS transaction_statut, t.date_transaction
            FROM dons d
            JOIN donateurs dt ON dt.id = d.donateur_id
            LEFT JOIN actions a ON a.id = d.action_id
            LEFT JOIN transactions t ON t.don_id = d.id
        ";

        $params = [];
        if ($statut !== null) {
            $sql .= " WHERE t.statut = :statut";
            $params['statut'] = $statut;
        }

        $sql .= " ORDER BY d.id DESC LIMIT {$limit}";

        return $this->rawQuery($sql, $params);
    }

    /**
     * Crée un don récurrent lié à un don
     */
    public function createRecurring(int $donId, string $frequence = 'mensuel'): int
    {
        $nextDate = match ($frequence) {
            'hebdomadaire' => date('Y-m-d', strtotime('+1 week')),
            'trimestriel' => date('Y-m-d', strtotime('+3 months')),
            'annuel' => date('Y-m-d', strtotime('+1 year')),
            default => date('Y-m-d', strtotime('+1 month'))
        };

        $stmt = $this->db->prepare("
            INSERT INTO dons_recurrents (don_id, frequence, prochaine_echeance, statut)
            VALUES (:don_id, :frequence, :prochaine_echeance, 'actif')
        ");
        $stmt->execute([
            'don_id' => $donId,
            'frequence' => $frequence,
            'prochaine_echeance' => $nextDate
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Récupère les dons récurrents actifs
     */
    public function getActiveRecurring(): array
    {
        $sql = "
            SELECT dr.*, d.montant, d.donateur_id, dt.nom, dt.prenom, dt.telephone
            FROM dons_recurrents dr
            JOIN dons d ON d.id = dr.don_id
            JOIN donateurs dt ON dt.id = d.donateur_id
            WHERE dr.statut = 'actif'
            ORDER BY dr.prochaine_echeance ASC
        ";
        return $this->rawQuery($sql);
    }
}
