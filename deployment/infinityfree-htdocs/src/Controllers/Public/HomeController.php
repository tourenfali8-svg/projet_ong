<?php

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Action;
use App\Models\ImpactReport;
use App\Models\News;
use App\Models\UrgentNeed;

/**
 * Contrôleur de la page d'accueil du site public
 */
class HomeController extends Controller
{
    public function index(Request $request): void
    {
        $actionModel = new Action();
        $impactModel = new ImpactReport();
        $newsModel = new News();
        $urgentModel = new UrgentNeed();

        // Récupération des actions prioritaires et récentes
        $actions = $actionModel->getWithDetails(null, 3);

        // Chiffres clés du tableau d'impact public (Innovation 12)
        $impactStats = $impactModel->getPublicImpactStats();

        // Dernières actualités
        $news = $newsModel->getPublished(3);

        // Alertes urgentes actives (Innovation 9)
        $urgentNeeds = $urgentModel->getActiveUrgentNeeds(2);

        $this->render('public.home', [
            'title' => 'Accueil — Agir ensemble pour changer des vies',
            'actions' => $actions,
            'impactStats' => $impactStats,
            'news' => $news,
            'urgentNeeds' => $urgentNeeds
        ]);
    }
}
