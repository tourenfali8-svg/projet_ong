<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Action;
use App\Models\Donation;
use App\Models\Donor;

/**
 * Contrôleur du CRM Intelligent & Analyse Prédictive (Innovation 11)
 */
class IntelligentCrmController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_dons');

        $donorModel = new Donor();
        $actionModel = new Action();
        $donationModel = new Donation();

        // 1. Donateurs réguliers (>= 3 dons)
        $regularDonors = $donorModel->getRegularDonors();

        // 2. Donateurs inactifs (> 6 mois sans don)
        $inactiveDonors = $donorModel->getInactiveDonors();

        // 3. Performance des campagnes et taux de complétion
        $campaignPerformance = $actionModel->getPerformanceStats();

        // 4. Dons récurrents actifs
        $recurringDonations = $donationModel->getActiveRecurring();

        $this->render('admin.crm_intelligent', [
            'title' => 'CRM Intelligent — Analyses Prédictives & Fidélisation',
            'regularDonors' => $regularDonors,
            'inactiveDonors' => $inactiveDonors,
            'campaignPerformance' => $campaignPerformance,
            'recurringDonations' => $recurringDonations
        ]);
    }
}
