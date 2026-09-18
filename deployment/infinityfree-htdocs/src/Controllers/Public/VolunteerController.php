<?php

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Mission;
use App\Models\Volunteer;

/**
 * Contrôleur de l'Espace Bénévoles & Volontariat (Innovation 10)
 */
class VolunteerController extends Controller
{
    public function index(Request $request): void
    {
        $missionModel = new Mission();
        $missions = $missionModel->getOpenMissions();

        $this->render('public.volunteers.index', [
            'title' => 'Devenir Bénévole — Rejoignez notre mission sur le terrain',
            'missions' => $missions
        ]);
    }

    public function apply(Request $request): void
    {
        $this->validateCsrfToken($request);

        $nom = trim($request->post('nom', ''));
        $prenom = trim($request->post('prenom', ''));
        $email = trim($request->post('email', ''));
        $telephone = trim($request->post('telephone', ''));
        $missionIdRaw = trim($request->post('mission_id', ''));
        $domainMap = [
            'graphiste' => 'Graphiste',
            'videaste' => 'Vidéaste',
            'montage-3d' => 'Montage 3D',
            'cadreur' => 'Cadreur',
            'logistique' => 'Logistique',
        ];

        $competences = $domainMap[$missionIdRaw] ?? trim($request->post('competences', ''));
        $missionId = is_numeric($missionIdRaw) ? (int)$missionIdRaw : null;

        if (empty($nom) || empty($prenom) || (empty($missionId) && empty($competences))) {
            $this->redirect('/benevolat', 'danger', 'Veuillez remplir les champs obligatoires.');
        }

        $volunteerModel = new Volunteer();
        $volunteer = $volunteerModel->findOrCreate([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'competences' => $competences
        ]);

        if ($missionId) {
            $volunteerModel->applyForMission((int)$volunteer['id'], $missionId);
        }

        $appConfig = require dirname(__DIR__, 3) . '/config/app.php';
        $whatsappPhone = preg_replace('/[^0-9]/', '', $appConfig['organization']['phone'] ?? '0507674208');
        $whatsappMessage = "Bonjour ONG AL HIKMAH, je souhaite devenir bénévole."
            . " Nom: {$nom}."
            . " Prénom: {$prenom}.";

        if (!empty($email)) {
            $whatsappMessage .= " Email: {$email}.";
        }

        if (!empty($telephone)) {
            $whatsappMessage .= " Téléphone: {$telephone}.";
        }

        $whatsappMessage .= " Compétences: {$competences}.";

        if ($missionId) {
            $whatsappMessage .= " Mission ciblée: {$missionId}.";
        }

        $this->redirect('https://wa.me/' . $whatsappPhone . '?text=' . urlencode($whatsappMessage));
    }
}
