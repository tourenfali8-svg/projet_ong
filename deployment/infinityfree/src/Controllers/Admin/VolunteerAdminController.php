<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Volunteer;

/**
 * Contrôleur CRM pour la Gestion des Bénévoles & Candidatures (Innovation 10)
 */
class VolunteerAdminController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_actions');

        $volunteerModel = new Volunteer();
        $applications = $volunteerModel->getAllApplications();

        $this->render('admin.volunteers.index', [
            'title' => 'Gestion des Candidatures Bénévoles',
            'applications' => $applications
        ]);
    }
}
