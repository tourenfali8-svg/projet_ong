<?php

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Action;

/**
 * Contrôleur des Actions / Campagnes humanitaires
 */
class ActionController extends Controller
{
    public function index(Request $request): void
    {
        $actionModel = new Action();
        $statutFilter = $request->query('statut');

        // Validation du filtre
        if (!in_array($statutFilter, ['planifiee', 'en_cours', 'terminee'], true)) {
            $statutFilter = null;
        }

        $actions = $actionModel->getWithDetails($statutFilter, 50);

        $this->render('public.actions.index', [
            'title' => 'Nos Actions & Projets sur le terrain',
            'actions' => $actions,
            'currentFilter' => $statutFilter
        ]);
    }

    public function show(Request $request): void
    {
        $id = (int)$request->param('id');
        $actionModel = new Action();
        $action = $actionModel->getFullDetails($id);

        if (!$action) {
            Response::notFound("L'action demandée n'existe pas ou a été archivée.");
        }

        $this->render('public.actions.show', [
            'title' => $action['titre'] . ' — Détails du projet',
            'action' => $action
        ]);
    }
}
