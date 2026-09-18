<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Action;
use App\Models\News;

/**
 * Contrôleur CRM pour la Gestion des Actualités & Articles (Spécification 4.1)
 */
class NewsAdminController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin', 'redacteur');

        $newsModel = new News();
        $actionModel = new Action();

        $articles = $newsModel->getAllForAdmin();
        $actions = $actionModel->all('id DESC');

        $this->render('admin.news.index', [
            'title' => 'Gestion des Actualités & Publications',
            'articles' => $articles,
            'actions' => $actions
        ]);
    }

    public function store(Request $request): void
    {
        Auth::requireRole('super_admin', 'redacteur');
        $this->validateCsrfToken($request);

        $titre = trim($request->post('titre', ''));
        $contenu = trim($request->post('contenu', ''));
        $statut = $request->post('statut', 'brouillon');
        $actionId = (int)$request->post('action_id');

        if (empty($titre) || empty($contenu)) {
            $this->redirect('/admin/actualites', 'danger', 'Le titre et le contenu de l\'actualité sont obligatoires.');
        }

        $newsModel = new News();
        $newsModel->create([
            'titre' => $titre,
            'contenu' => $contenu,
            'statut' => $statut,
            'action_id' => $actionId ?: null,
            'auteur_id' => Auth::id(),
            'date_publication' => ($statut === 'publie') ? date('Y-m-d H:i:s') : null,
            'date_creation' => date('Y-m-d H:i:s')
        ]);

        $this->redirect('/admin/actualites', 'success', 'Actualité enregistrée avec succès.');
    }

    public function delete(Request $request): void
    {
        Auth::requireRole('super_admin', 'redacteur');
        $this->validateCsrfToken($request);

        $id = (int)$request->param('id');
        $newsModel = new News();
        $newsModel->delete($id);

        $this->redirect('/admin/actualites', 'info', 'Actualité supprimée.');
    }
}
