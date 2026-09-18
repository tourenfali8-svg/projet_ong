<?php

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Request;
use App\Models\UrgentNeed;

/**
 * Contrôleur des Urgences & Besoins Immédiats (Innovation 9)
 */
class UrgentNeedController extends Controller
{
    public function index(Request $request): void
    {
        $urgentModel = new UrgentNeed();
        $urgentNeeds = $urgentModel->getActiveUrgentNeeds(20);

        $this->render('public.urgent_needs.index', [
            'title' => 'Besoins Urgents — Interventions prioritaires',
            'urgentNeeds' => $urgentNeeds
        ]);
    }
}
