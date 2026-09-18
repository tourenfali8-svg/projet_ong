<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Action;
use App\Models\Zone;

/**
 * Contrôleur CRM pour la Gestion des Actions (Spécification 3.4)
 */
class ActionAdminController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_actions');

        $actionModel = new Action();
        $actions = $actionModel->getWithDetails();

        $this->render('admin.actions.index', [
            'title' => 'Gestion des Actions & Projets',
            'actions' => $actions
        ]);
    }

    public function createForm(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_actions');

        $zoneModel = new Zone();
        $zones = $zoneModel->all('nom ASC');

        $this->render('admin.actions.create', [
            'title' => 'Créer une nouvelle Action Humanitaire',
            'zones' => $zones
        ]);
    }

    public function store(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_actions');
        $this->validateCsrfToken($request);

        $titre = trim($request->post('titre', ''));
        $description = trim($request->post('description', ''));
        $zoneId = (int)$request->post('zone_id');
        $statut = $request->post('statut', 'planifiee');
        $objectifFinancier = (float)$request->post('objectif_financier', 0);
        $dateDebut = $request->post('date_debut') ?: null;
        $dateFin = $request->post('date_fin') ?: null;

        if (empty($titre)) {
            $this->redirect('/admin/actions/nouveau', 'danger', 'Le titre de l\'action est obligatoire.');
        }

        $actionModel = new Action();
        $actionId = $actionModel->create([
            'titre' => $titre,
            'description' => $description,
            'statut' => $statut,
            'zone_id' => $zoneId ?: null,
            'objectif_financier' => $objectifFinancier,
            'montant_collecte' => 0,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'cree_par' => Auth::id()
        ]);

        $this->redirect('/admin/actions', 'success', 'L\'action humanitaire a été créée avec succès.');
    }

    public function delete(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_actions');
        $this->validateCsrfToken($request);

        $id = (int)$request->param('id');
        $actionModel = new Action();
        $actionModel->delete($id);

        $this->redirect('/admin/actions', 'info', 'L\'action a été supprimée.');
    }
}
