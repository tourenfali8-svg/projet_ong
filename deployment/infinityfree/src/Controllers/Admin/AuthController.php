<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;

/**
 * Contrôleur d'authentification à l'espace CRM Administrateur
 */
class AuthController extends Controller
{
    protected string $defaultLayout = 'auth';

    public function loginForm(Request $request): void
    {
        if (Auth::check()) {
            $this->redirect('/admin/dashboard');
        }

        $this->render('admin.auth.login', [
            'title' => 'Connexion — Espace Administration CRM'
        ]);
    }

    public function login(Request $request): void
    {
        $this->validateCsrfToken($request);

        $email = trim($request->post('email', ''));
        $password = (string)$request->post('password', '');

        if (empty($email) || empty($password)) {
            $this->redirect('/admin/login', 'danger', 'Veuillez saisir votre adresse email et votre mot de passe.');
        }

        if (Auth::attempt($email, $password)) {
            $this->redirect('/admin/dashboard', 'success', 'Bienvenue sur votre espace CRM !');
        }

        $this->redirect('/admin/login', 'danger', 'Identifiants invalides ou compte inactif.');
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $this->redirect('/admin/login', 'info', 'Vous avez été déconnecté avec succès.');
    }
}
