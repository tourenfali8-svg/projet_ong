<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Models\Donation;

/**
 * Contrôleur CRM pour la Gestion des Dons & Transactions (Spécification 3.3)
 */
class DonationAdminController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin', 'gestionnaire_dons');

        $statutFilter = $request->query('statut');
        if (!in_array($statutFilter, ['confirme', 'en_attente', 'echoue', 'rembourse'], true)) {
            $statutFilter = null;
        }

        $donationModel = new Donation();
        $donations = $donationModel->getAllWithDetails(100, $statutFilter);

        $this->render('admin.donations.index', [
            'title' => 'Suivi des Dons & Transactions Financières',
            'donations' => $donations,
            'currentFilter' => $statutFilter
        ]);
    }
}
