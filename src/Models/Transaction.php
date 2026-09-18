<?php

namespace App\Models;

use App\Core\Model;

/**
 * Modèle des Transactions de paiement
 */
class Transaction extends Model
{
    protected string $table = 'transactions';

    /**
     * Recherche une transaction par sa référence unique
     */
    public function findByReference(string $reference): ?array
    {
        return $this->findFirst(['reference_transaction' => $reference]);
    }

    /**
     * Met à jour le statut d'une transaction et synchronise l'action si nécessaire
     */
    public function updateStatus(int $transactionId, string $newStatus): bool
    {
        $updated = $this->update($transactionId, ['statut' => $newStatus]);

        if ($updated && $newStatus === 'confirme') {
            // Mise à jour de l'action liée
            $tx = $this->find($transactionId);
            if ($tx) {
                $donStmt = $this->db->prepare("SELECT action_id FROM dons WHERE id = :id");
                $donStmt->execute(['id' => $tx['don_id']]);
                $actionId = $donStmt->fetchColumn();

                if ($actionId) {
                    $actionModel = new Action();
                    $actionModel->refreshMontantCollecte((int)$actionId);
                }
            }
        }

        return $updated;
    }

    /**
     * Génère une référence de transaction unique
     */
    public static function generateReference(string $operator): string
    {
        $prefix = match ($operator) {
            'wave' => 'WV-',
            'orange_money' => 'OM-',
            'mtn_money' => 'MTN-',
            'moov_money' => 'MV-',
            default => 'TX-'
        };

        return $prefix . strtoupper(date('YmdHis')) . '-' . rand(1000, 9999);
    }
}
