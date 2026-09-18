<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'CRM Administration — ONG AL HIKMAH') ?></title>
    <link rel="stylesheet" href="/assets/css/crm.css">
</head>
<body class="crm-body">
    <div class="crm-wrapper">
        <!-- Barre latérale / Sidebar -->
        <aside class="crm-sidebar">
            <div class="crm-brand">
                <span class="brand-badge">CRM</span>
                <h3>ONG AL HIKMAH</h3>
            </div>
            <nav class="crm-nav">
                <div class="nav-section-title">PILOTAGE</div>
                <a href="/admin/dashboard" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'dashboard') ? 'active' : '' ?>">
                    📊 Tableau de bord
                </a>
                <a href="/admin/crm-intelligent" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'crm-intelligent') ? 'active' : '' ?>">
                    🧠 CRM Intelligent
                </a>

                <div class="nav-section-title">ACTIVITÉS HUMANITAIRES</div>
                <a href="/admin/actions" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'actions') ? 'active' : '' ?>">
                    🎯 Actions & Projets
                </a>
                <a href="/admin/beneficiaires" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'beneficiaires') ? 'active' : '' ?>">
                    🤝 Bénéficiaires
                </a>
                <a href="/admin/benevoles" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'benevoles') ? 'active' : '' ?>">
                    🙋‍♂️ Bénévoles & Missions
                </a>

                <div class="nav-section-title">FINANCES & DONS</div>
                <a href="/admin/donateurs" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'donateurs') ? 'active' : '' ?>">
                    👥 Donateurs & Fidélité
                </a>
                <a href="/admin/dons" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'dons') ? 'active' : '' ?>">
                    💳 Dons & Transactions
                </a>
                <a href="/admin/exports" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'exports') ? 'active' : '' ?>">
                    📥 Exports de données
                </a>

                <div class="nav-section-title">CONTENUS & ÉQUIPE</div>
                <a href="/admin/actualites" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'actualites') ? 'active' : '' ?>">
                    📰 Actualités & Blog
                </a>
                <a href="/admin/utilisateurs" class="crm-nav-link <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'utilisateurs') ? 'active' : '' ?>">
                    ⚙️ Utilisateurs & Rôles
                </a>

                <div class="nav-section-title">LIENS EXTERNES</div>
                <a href="/" target="_blank" class="crm-nav-link">
                    🌐 Voir le site public
                </a>
            </nav>
            <div class="crm-sidebar-footer">
                <a href="/admin/logout" class="crm-logout-btn">Déconnexion</a>
            </div>
        </aside>

        <!-- Zone de contenu principale -->
        <div class="crm-main-area">
            <header class="crm-topbar">
                <div class="topbar-title">
                    <h2><?= htmlspecialchars($title ?? 'Espace CRM') ?></h2>
                </div>
                <div class="topbar-user">
                    <span class="user-role-tag"><?= htmlspecialchars($currentUser['role_nom'] ?? 'Membre') ?></span>
                    <strong><?= htmlspecialchars(($currentUser['prenom'] ?? '') . ' ' . ($currentUser['nom'] ?? 'Admin')) ?></strong>
                </div>
            </header>

            <!-- Messages Flash -->
            <?php require dirname(__DIR__) . '/partials/flash.php'; ?>

            <main class="crm-content">
                <?= $content ?>
            </main>
        </div>
    </div>
</body>
</html>
