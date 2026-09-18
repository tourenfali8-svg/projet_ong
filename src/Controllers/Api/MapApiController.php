<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Zone;

/**
 * Contrôleur API pour la Carte Interactive des Actions (Innovation 4)
 */
class MapApiController extends Controller
{
    public function zones(Request $request): void
    {
        $zoneModel = new Zone();
        $zones = $zoneModel->getWithActions();

        $this->json([
            'success' => true,
            'data' => $zones
        ]);
    }
}
