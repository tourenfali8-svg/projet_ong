<?php
/**
 * Point d'Entrée Unique (Front Controller)
 * Plateforme Web & CRM — ONG
 */

declare(strict_types=1);

// 1. Définition du fuseau horaire par défaut
date_default_timezone_set('Africa/Abidjan');

// 2. Chargement du fichier .env manuel (sans dépendance externe)
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '#')) {
            continue;
        }
        if (str_contains($line, '=')) {
            [$key, $val] = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            $_ENV[$key] = $val;
            putenv("{$key}={$val}");
        }
    }
}

// 3. Enregistrement de l'Autoloader PSR-4
require_once dirname(__DIR__) . '/src/Core/Autoloader.php';
\App\Core\Autoloader::register();

// Si composer autoload existe, le charger également
if (file_exists(dirname(__DIR__) . '/vendor/autoload.php')) {
    require_once dirname(__DIR__) . '/vendor/autoload.php';
}

// 4. Initialisation de la Session
\App\Core\Session::start();

// 5. Initialisation de la Requête et du Routeur
$request = new \App\Core\Request();
$router = new \App\Core\Router($request);

// =====================================================================
// DÉFINITION DES ROUTES DE L'APPLICATION
// =====================================================================

// --- 1. Site Public ---
$router->get('/', [\App\Controllers\Public\HomeController::class, 'index']);
$router->get('/a-propos', [\App\Controllers\Public\AboutController::class, 'index']);
$router->post('/a-propos/contact', [\App\Controllers\Public\AboutController::class, 'submitContact']);
$router->get('/actions', [\App\Controllers\Public\ActionController::class, 'index']);
$router->get('/actions/{id}', [\App\Controllers\Public\ActionController::class, 'show']);
$router->get('/urgences', [\App\Controllers\Public\UrgentNeedController::class, 'index']);
$router->get('/benevolat', [\App\Controllers\Public\VolunteerController::class, 'index']);
$router->post('/benevolat/postuler', [\App\Controllers\Public\VolunteerController::class, 'apply']);
$router->get('/actualites', [\App\Controllers\Public\NewsController::class, 'index']);
$router->get('/actualites/{id}', [\App\Controllers\Public\NewsController::class, 'show']);
$router->get('/impact', [\App\Controllers\Public\ImpactController::class, 'index']);

// --- 2. Système de Dons & Espace Donateur ---
$router->get('/don', [\App\Controllers\Donation\DonationController::class, 'form']);
$router->post('/don/traiter', [\App\Controllers\Donation\PaymentController::class, 'process']);
$router->get('/don/succes/{ref}', [\App\Controllers\Donation\PaymentController::class, 'success']);

// --- 3. CRM & Espace Administrateur ---
$router->get('/admin/login', [\App\Controllers\Admin\AuthController::class, 'loginForm']);
$router->post('/admin/login', [\App\Controllers\Admin\AuthController::class, 'login']);
$router->get('/admin/logout', [\App\Controllers\Admin\AuthController::class, 'logout']);
$router->get('/admin', [\App\Controllers\Admin\DashboardController::class, 'index']);
$router->get('/admin/dashboard', [\App\Controllers\Admin\DashboardController::class, 'index']);

$router->get('/admin/actions', [\App\Controllers\Admin\ActionAdminController::class, 'index']);
$router->get('/admin/actions/nouveau', [\App\Controllers\Admin\ActionAdminController::class, 'createForm']);
$router->post('/admin/actions/nouveau', [\App\Controllers\Admin\ActionAdminController::class, 'store']);
$router->post('/admin/actions/supprimer/{id}', [\App\Controllers\Admin\ActionAdminController::class, 'delete']);

$router->get('/admin/donateurs', [\App\Controllers\Admin\DonorAdminController::class, 'index']);
$router->get('/admin/donateurs/{id}', [\App\Controllers\Admin\DonorAdminController::class, 'show']);

$router->get('/admin/dons', [\App\Controllers\Admin\DonationAdminController::class, 'index']);
$router->get('/admin/crm-intelligent', [\App\Controllers\Admin\IntelligentCrmController::class, 'index']);

$router->get('/admin/beneficiaires', [\App\Controllers\Admin\BeneficiaryAdminController::class, 'index']);
$router->post('/admin/beneficiaires/nouveau', [\App\Controllers\Admin\BeneficiaryAdminController::class, 'store']);

$router->get('/admin/actualites', [\App\Controllers\Admin\NewsAdminController::class, 'index']);
$router->post('/admin/actualites/nouveau', [\App\Controllers\Admin\NewsAdminController::class, 'store']);
$router->post('/admin/actualites/supprimer/{id}', [\App\Controllers\Admin\NewsAdminController::class, 'delete']);

$router->get('/admin/benevoles', [\App\Controllers\Admin\VolunteerAdminController::class, 'index']);

$router->get('/admin/utilisateurs', [\App\Controllers\Admin\UserAdminController::class, 'index']);
$router->post('/admin/utilisateurs/nouveau', [\App\Controllers\Admin\UserAdminController::class, 'store']);

$router->get('/admin/exports', [\App\Controllers\Admin\ExportController::class, 'index']);
$router->get('/admin/exports/donateurs', [\App\Controllers\Admin\ExportController::class, 'exportDonors']);
$router->get('/admin/exports/dons', [\App\Controllers\Admin\ExportController::class, 'exportDonations']);

// --- 4. API Endpoints (Chatbot & Carte Interactive) ---
$router->post('/api/chatbot', [\App\Controllers\Api\ChatbotApiController::class, 'message']);
$router->get('/api/zones', [\App\Controllers\Api\MapApiController::class, 'zones']);

// 6. Exécution du routeur
$router->dispatch();
