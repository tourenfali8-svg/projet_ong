<?php

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Request;
use App\Models\ImpactReport;
use App\Models\Zone;

/**
 * Contrôleur du Tableau d'Impact Public (Innovation 12 & 7)
 */
class ImpactController extends Controller
{
    public function index(Request $request): void
    {
        $impactModel = new ImpactReport();
        $zoneModel = new Zone();

        $stats = $impactModel->getPublicImpactStats();
        $reports = $impactModel->getAllPublishedReports();
        $zones = $zoneModel->getWithActions();

        $this->render('public.impact', [
            'title' => 'Transparence & Impact Public — Vos dons en action',
            'stats' => $stats,
            'reports' => $reports,
            'zones' => $zones
        ]);
    }
}
