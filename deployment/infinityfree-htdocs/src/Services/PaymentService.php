<?php

namespace App\Services;

use App\Models\Transaction;

/**
 * Service de traitement et de simulation des passerelles de paiement (Mobile Money & Wave)
 */
class PaymentService
{
    private array $config;

    public function __construct()
    {
        $this->config = require dirname(__DIR__, 2) . '/config/payment.php';
    }

    /**
     * Initie un paiement auprès de l'opérateur choisi
     */
    public function initiatePayment(int $donId, float $montant, string $operateur, string $telephone): array
    {
        $reference = Transaction::generateReference($operateur);

        $transactionModel = new Transaction();
        $transactionId = $transactionModel->create([
            'don_id' => $donId,
            'operateur_paiement' => $operateur,
            'reference_transaction' => $reference,
            'statut' => 'en_attente'
        ]);

        // En mode simulation (par défaut), validation automatique ou guidée
        if ($this->config['mode'] === 'simulation') {
            return [
                'success' => true,
                'transaction_id' => $transactionId,
                'reference' => $reference,
                'operateur' => $operateur,
                'montant' => $montant,
                'mode' => 'simulation',
                'message' => "Demande de paiement simulée pour {$operateur} sur le numéro {$telephone}."
            ];
        }

        // Mode réel : branchement vers les APIs officielles des opérateurs (Wave Checkout, Orange OM, MTN MoMo)
        return [
            'success' => true,
            'transaction_id' => $transactionId,
            'reference' => $reference,
            'operateur' => $operateur,
            'montant' => $montant,
            'mode' => 'live',
            'redirect_url' => "/don/paiement/authentification/{$reference}"
        ];
    }

    /**
     * Confirme le paiement avec succès
     */
    public function confirmPayment(int $transactionId): bool
    {
        $transactionModel = new Transaction();
        return $transactionModel->updateStatus($transactionId, 'confirme');
    }

    /**
     * Marque un paiement comme échoué
     */
    public function failPayment(int $transactionId): bool
    {
        $transactionModel = new Transaction();
        return $transactionModel->updateStatus($transactionId, 'echoue');
    }
}
