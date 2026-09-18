<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Models\Action;
use App\Models\Donation;

/**
 * Contrôleur du Tableau de Bord CRM (Spécification 3.1)
 */
class DashboardController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireAuth();

        $db = Database::getConnection();

        // Récupération des données agrégées sans vue SQL (compatible hébergement mutualisé).
        $stmt = $db->query("
            SELECT
                (SELECT COUNT(*) FROM donateurs) AS nombre_donateurs,
                (SELECT COUNT(*) FROM dons) AS nombre_dons,
                (SELECT COALESCE(SUM(d.montant), 0) FROM dons d JOIN transactions t ON t.don_id = d.id WHERE t.statut = 'confirme') AS montant_total_collecte,
                (SELECT COUNT(*) FROM actions) AS nombre_actions,
                (SELECT COUNT(*) FROM transactions WHERE statut = 'en_attente') AS transactions_en_attente,
                (SELECT COUNT(*) FROM transactions WHERE statut = 'confirme') AS transactions_confirmees,
                (SELECT COUNT(*) FROM transactions WHERE statut = 'echoue') AS transactions_echouees
        ");
        $kpis = $stmt->fetch() ?: [
            'nombre_donateurs' => 0,
            'nombre_dons' => 0,
            'montant_total_collecte' => 0,
            'nombre_actions' => 0,
            'transactions_en_attente' => 0,
            'transactions_confirmees' => 0,
            'transactions_echouees' => 0
        ];

        // Dernières transactions récentes
        $donationModel = new Donation();
        $recentDonations = $donationModel->getAllWithDetails(6);

        // Actions prioritaires
        $actionModel = new Action();
        $actions = $actionModel->getWithDetails(null, 5);

        $this->render('admin.dashboard', [
            'title' => 'Tableau de bord CRM & Statistiques',
            'kpis' => $kpis,
            'recentDonations' => $recentDonations,
            'actions' => $actions
        ]);
    }
}
