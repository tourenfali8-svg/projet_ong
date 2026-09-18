<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Models\User;

/**
 * Contrôleur CRM pour la Gestion des Utilisateurs & Droits d'Accès (Spécification 5.1 & 5.2)
 */
class UserAdminController extends Controller
{
    protected string $defaultLayout = 'admin';

    public function index(Request $request): void
    {
        Auth::requireRole('super_admin');

        $userModel = new User();
        $users = $userModel->getAllWithRoles();
        $roles = $userModel->getRoles();

        $this->render('admin.users.index', [
            'title' => 'Gestion des Utilisateurs & Rôles CRM',
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function store(Request $request): void
    {
        Auth::requireRole('super_admin');
        $this->validateCsrfToken($request);

        $nom = trim($request->post('nom', ''));
        $prenom = trim($request->post('prenom', ''));
        $email = trim($request->post('email', ''));
        $telephone = trim($request->post('telephone', ''));
        $motDePasse = (string)$request->post('password', '');
        $roleId = (int)$request->post('role_id');

        if (empty($nom) || empty($prenom) || empty($email) || empty($motDePasse) || empty($roleId)) {
            $this->redirect('/admin/utilisateurs', 'danger', 'Tous les champs obligatoires doivent être renseignés.');
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $this->redirect('/admin/utilisateurs', 'danger', 'Un compte avec cette adresse email existe déjà.');
        }

        $userModel->registerUser([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'mot_de_passe' => $motDePasse,
            'role_id' => $roleId,
            'statut' => 'actif'
        ]);

        $this->redirect('/admin/utilisateurs', 'success', 'Le compte utilisateur a été créé avec succès.');
    }
}
