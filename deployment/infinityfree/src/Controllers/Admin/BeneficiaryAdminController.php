<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Beneficiary;
use App\Models\Zone;

/**
 * Contrôleur CRM pour la Gestion des Bénéficiaires (Spécification 3.5)
 */
class BeneficiaryAdminController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_actions');

        $beneficiaryModel = new Beneficiary();
        $zoneModel = new Zone();

        $beneficiaries = $beneficiaryModel->getAllWithZone();
        $zones = $zoneModel->all('nom ASC');

        $this->render('admin.beneficiaries.index', [
            'title' => 'Gestion des Bénéficiaires & Besoins Locaux',
            'beneficiaries' => $beneficiaries,
            'zones' => $zones
        ]);
    }

    public function store(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_actions');
        $this->validateCsrfToken($request);

        $nom = trim($request->post('nom', ''));
        $zoneId = (int)$request->post('zone_id');
        $besoins = trim($request->post('besoins', ''));
        $informations = trim($request->post('informations', ''));

        if (empty($nom)) {
            $this->redirect('/admin/beneficiaires', 'danger', 'Le nom du bénéficiaire ou de la communauté est obligatoire.');
        }

        $beneficiaryModel = new Beneficiary();
        $beneficiaryModel->create([
            'nom' => $nom,
            'zone_id' => $zoneId ?: null,
            'besoins' => $besoins,
            'informations' => $informations
        ]);

        $this->redirect('/admin/beneficiaires', 'success', 'Bénéficiaire enregistré avec succès.');
    }
}
