<?php

namespace App\Controllers\Donation;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Action;

/**
 * Contrôleur du Formulaire de Don Intelligent (Innovations 2 & 3)
 */
class DonationController extends Controller
{
    public function form(Request $request): void
    {
        $actionModel = new Action();
        $actions = $actionModel->getWithDetails('en_cours');

        // Pré-sélection éventuelle d'une action via l'URL ?action=X
        $selectedActionId = (int)$request->query('action', 0);
        $selectedAction = null;
        if ($selectedActionId > 0) {
            $selectedAction = $actionModel->getFullDetails($selectedActionId);
        }

        $paymentConfig = require dirname(__DIR__, 3) . '/config/payment.php';

        $this->render('donation.form', [
            'title' => 'Faire un Don — Soutenir nos actions sur le terrain',
            'actions' => $actions,
            'selectedAction' => $selectedAction,
            'operators' => $paymentConfig['operators']
        ]);
    }
}
