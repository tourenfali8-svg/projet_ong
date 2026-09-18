<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Transaction;
use App\Services\ExportService;

/**
 * Contrôleur des Exports de données (Spécification 6.1)
 */
class ExportController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin');

        $this->render('admin.exports.index', [
            'title' => 'Exports de Données & Reporting'
        ]);
    }

    public function exportDonors(Request $request): void
    {
        Auth::requireRole('super_admin');

        $donorModel = new Donor();
        $donors = $donorModel->getAllWithSummary();

        $headers = ['ID', 'Nom', 'Prénom', 'Téléphone', 'Email', 'Adresse', 'Niveau Fidélité', 'Points', 'Total Dons', 'Montant Total (FCFA)', 'Date Inscription'];
        $rows = [];

        foreach ($donors as $d) {
            $rows[] = [
                $d['id'],
                $d['nom'],
                $d['prenom'],
                $d['telephone'],
                $d['email'] ?? '',
                $d['adresse'] ?? '',
                $d['niveau_nom'] ?? 'Bronze',
                $d['points_fidelite'],
                $d['total_dons'],
                $d['total_montant_donne'],
                $d['date_creation']
            ];
        }

        ExportService::logExport(Auth::id(), 'donateurs', 'csv');
        ExportService::outputCsv('export_donateurs_' . date('Ymd_His') . '.csv', $headers, $rows);
    }

    public function exportDonations(Request $request): void
    {
        Auth::requireRole('super_admin');

        $donationModel = new Donation();
        $donations = $donationModel->getAllWithDetails(5000);

        $headers = ['ID Don', 'Donateur', 'Téléphone', 'Action Soutenue', 'Montant (FCFA)', 'Type Don', 'Affectation', 'Opérateur', 'Réf Transaction', 'Statut Transaction', 'Date'];
        $rows = [];

        foreach ($donations as $d) {
            $rows[] = [
                $d['id'],
                $d['donateur_prenom'] . ' ' . $d['donateur_nom'],
                $d['donateur_telephone'],
                $d['action_titre'] ?? 'Fonds général',
                $d['montant'],
                $d['type_don'],
                $d['affectation'],
                $d['operateur_paiement'] ?? '',
                $d['reference_transaction'] ?? '',
                $d['transaction_statut'] ?? '',
                $d['date_don']
            ];
        }

        ExportService::logExport(Auth::id(), 'dons', 'csv');
        ExportService::outputCsv('export_dons_' . date('Ymd_His') . '.csv', $headers, $rows);
    }
}
