<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Connexion — Administration CRM') ?></title>
    <link rel="stylesheet" href="/assets/css/crm.css">
</head>
<body class="auth-body">
    <div class="auth-card">
        <div class="auth-header">
            <span class="auth-logo">❤ ONG AL HIKMAH</span>
            <h2>Administration de l'ONG</h2>
            <p>Connectez-vous pour accéder au tableau de bord</p>
        </div>

        <?php require dirname(__DIR__) . '/partials/flash.php'; ?>

        <div class="auth-body-content">
            <?= $content ?>
        </div>

        <div class="auth-footer">
            <a href="/">← Retourner au site public</a>
        </div>
    </div>
</body>
</html>
