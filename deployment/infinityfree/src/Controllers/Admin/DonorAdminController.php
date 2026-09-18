<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Donor;

/**
 * Contrôleur CRM pour la Gestion des Donateurs (Spécification 3.2)
 */
class DonorAdminController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_dons');

        $donorModel = new Donor();
        $donors = $donorModel->getAllWithSummary();

        $this->render('admin.donors.index', [
            'title' => 'Gestion des Donateurs & Fidélisation',
            'donors' => $donors
        ]);
    }

    public function show(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_dons');

        $id = (int)$request->param('id');
        $donorModel = new Donor();
        $donor = $donorModel->getProfileWithBadges($id);

        if (!$donor) {
            Response::notFound("Donateur introuvable.");
        }

        $this->render('admin.donors.show', [
            'title' => 'Fiche Donateur — ' . $donor['prenom'] . ' ' . $donor['nom'],
            'donor' => $donor
        ]);
    }
}
