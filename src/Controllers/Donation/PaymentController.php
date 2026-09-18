<?php

namespace App\Controllers\Donation;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Transaction;

/**
 * Contrôleur de traitement des paiements et confirmation des dons
 */
class PaymentController extends Controller
{
    public function process(Request $request): void
    {
        $this->validateCsrfToken($request);

        // Récupération des données du formulaire
        $montant = (float)$request->post('montant', 0);
        $typeDon = $request->post('type_don', 'ponctuel');
        $frequence = $request->post('frequence', 'mensuel');
        $actionId = $request->post('action_id') ? (int)$request->post('action_id') : null;
        $affectation = trim($request->post('affectation', ''));
        $message = trim($request->post('message', ''));
        $anonyme = (bool)$request->post('anonyme', false);

        // Données du donateur
        $nom = trim($request->post('nom', ''));
        $prenom = trim($request->post('prenom', ''));
        $telephone = trim($request->post('telephone', ''));
        $email = trim($request->post('email', ''));
        $operateur = $request->post('operateur', 'wave');

        if ($montant <= 0 || empty($nom) || empty($prenom)) {
            $this->redirect('/don', 'danger', 'Veuillez saisir un montant valide ainsi que votre nom et prénom.');
        }

        // 1. Enregistrement ou récupération du donateur
        $donorModel = new Donor();
        $donor = $donorModel->findOrCreate([
            'nom' => $nom,
            'prenom' => $prenom,
            'telephone' => $telephone,
            'email' => $email
        ]);
        $donorId = (int)$donor['id'];

        // 2. Enregistrement du don
        $donationModel = new Donation();
        $donId = $donationModel->create([
            'donateur_id' => $donorId,
            'action_id' => $actionId,
            'montant' => $montant,
            'type_don' => $typeDon,
            'affectation' => !empty($affectation) ? $affectation : 'Mission générale',
            'message_donateur' => !empty($message) ? $message : null,
            'anonyme' => $anonyme ? 1 : 0
        ]);

        // Si don récurrent choisi
        if ($typeDon === 'recurrent') {
            $donationModel->createRecurring($donId, $frequence);
        }

        $appConfig = require dirname(__DIR__, 3) . '/config/app.php';

        $messageDon = "Bonjour ONG AL HIKMAH, je souhaite faire un don de "
            . number_format($montant, 0, ',', ' ') . " FCFA."
            . " Je m'appelle {$prenom} {$nom}.";

        if (!empty($telephone)) {
            $messageDon .= " Mon téléphone est {$telephone}.";
        }

        if (!empty($email)) {
            $messageDon .= " Mon email est {$email}.";
        }

        $messageDon .= " Merci.";

        $whatsappPhone = preg_replace('/[^0-9]/', '', $appConfig['organization']['phone'] ?? '2250507674208');

        $this->redirect('https://wa.me/' . $whatsappPhone . '?text=' . urlencode($messageDon));
    }

    public function success(Request $request): void
    {
        $ref = $request->param('ref');
        $txModel = new Transaction();
        $tx = $txModel->findByReference($ref);

        if (!$tx) {
            Response::notFound("Transaction introuvable.");
        }

        $donModel = new Donation();
        $don = $donModel->find($tx['don_id']);

        $donorModel = new Donor();
        $donor = $donorModel->getProfileWithBadges((int)$don['donateur_id']);

        $this->render('donation.success', [
            'title' => 'Merci pour votre don !',
            'transaction' => $tx,
            'don' => $don,
            'donor' => $donor
        ]);
    }
}
