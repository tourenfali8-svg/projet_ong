<?php

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Request;

/**
 * Contrôleur de la page À Propos
 */
class AboutController extends Controller
{
    public function index(Request $request): void
    {
        $this->render('public.about', [
            'title' => 'À Propos de notre ONG — Mission, Vision & Valeurs'
        ]);
    }

    public function submitContact(Request $request): void
    {
        $this->validateCsrfToken($request);

        $nom = trim((string)$request->post('nom', ''));
        $email = trim((string)$request->post('email', ''));
        $objet = trim((string)$request->post('objet', ''));
        $message = trim((string)$request->post('message', ''));

        if ($nom === '' || $email === '' || $objet === '' || $message === '') {
            $this->redirect('/a-propos', 'danger', 'Veuillez remplir tous les champs du formulaire de contact.');
            return;
        }

        $logFile = dirname(__DIR__, 3) . '/storage/logs/contact_messages.log';
        $line = sprintf(
            "[%s] %s <%s> — %s\n%s\n\n",
            date('Y-m-d H:i:s'),
            $nom,
            $email,
            $objet,
            $message
        );

        @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

        $appConfig = require dirname(__DIR__, 3) . '/config/app.php';
        $whatsappPhone = preg_replace('/[^0-9]/', '', $appConfig['organization']['phone'] ?? '0507674208');
        $whatsappMessage = "Bonjour ONG AL HIKMAH, je souhaite vous contacter."
            . " Nom: {$nom}."
            . " Email: {$email}."
            . " Objet: {$objet}."
            . " Message: {$message}.";

        $this->redirect('https://wa.me/' . $whatsappPhone . '?text=' . urlencode($whatsappMessage));
    }
}
