<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? $appConfig['name']) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- En-tête / Barre de navigation -->
    <header class="site-header">
        <div class="container navbar-container">
            <a href="/" class="brand-logo" aria-label="Accueil ONG AL HIKMAH">
                <img src="/assets/images/logo-ong-original.jpeg" alt="Logo original ONG AL HIKMAH" class="brand-logo-image">
            </a>
            
            <nav class="main-nav">
                <a href="/" class="nav-link">Accueil</a>
                <a href="/a-propos" class="nav-link">À Propos</a>
                <a href="/actions" class="nav-link">Nos Actions</a>
                <a href="/urgences" class="nav-link nav-urgent">Urgences</a>
                <a href="/impact" class="nav-link">Impact Public</a>
                <a href="/benevolat" class="nav-link">Bénévolat</a>
                <a href="/actualites" class="nav-link">Actualités</a>
            </nav>

            <div class="header-actions">
                <a href="/don" class="btn btn-primary btn-donate">Faire un don</a>
            </div>
        </div>
    </header>

    <!-- Messages Flash -->
    <?php require dirname(__DIR__) . '/partials/flash.php'; ?>

    <!-- Contenu Principal -->
    <main class="main-content">
        <?= $content ?>
    </main>

    <!-- Pied de page -->
    <footer class="site-footer">
        <div class="container footer-cta">
            <div>
                <span class="footer-kicker">Agissons ensemble</span>
                <h2>Chaque geste peut éclairer un avenir.</h2>
                <p>Votre soutien permet à l’ONG AL HIKMAH de guider, accompagner et renforcer les communautés.</p>
            </div>
            <div class="footer-cta-actions">
                <a href="/don" class="btn btn-footer-donate">Faire un don</a>
                <a href="https://wa.me/2250507674208" target="_blank" rel="noopener noreferrer" class="btn btn-footer-contact">Nous écrire</a>
            </div>
        </div>
        <div class="container footer-grid">
            <div class="footer-col footer-brand">
                <img src="/assets/images/logo-ong-original.jpeg" alt="Logo original ONG AL HIKMAH" class="footer-logo">
                <h3><?= htmlspecialchars($appConfig['organization']['name']) ?></h3>
                <p><?= htmlspecialchars($appConfig['organization']['slogan']) ?></p>
                <p>Organisation à but non lucratif engagée dans le développement, la guidance et l'accompagnement des personnes par la voie ancestrale.</p>
            </div>
            <div class="footer-col footer-links">
                <h4>Découvrir</h4>
                <ul>
                    <li><a href="/a-propos">Qui sommes-nous ?</a></li>
                    <li><a href="/actions">Catalogue des actions</a></li>
                    <li><a href="/urgences">Besoins urgents prioritaires</a></li>
                    <li><a href="/impact">Transparence & Impact</a></li>
                    <li><a href="/benevolat">Rejoindre comme bénévole</a></li>
                </ul>
            </div>
            <div class="footer-col footer-contact">
                <h4>Nous contacter</h4>
                <p><span aria-hidden="true">📍</span> Abobo Anador, Abidjan, Côte d'Ivoire</p>
                <p><span aria-hidden="true">📞</span> <a href="tel:+2250507674208">+225 05 07 67 42 08</a></p>
                <p><span aria-hidden="true">✉</span> <a href="mailto:alhikmah050767@gmail.com">alhikmah050767@gmail.com</a></p>

                <div class="social-links" aria-label="Réseaux sociaux">
                    <a href="https://youtube.com/@alhikmah-k2u?si=ODXF3dVDghn56alJ" target="_blank" rel="noopener noreferrer" class="social-link social-youtube" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M23.5 6.2c-.3-1.2-1.2-2.1-2.4-2.4C19.2 3.4 12 3.4 12 3.4s-7.2 0-9.1.4C1.7 4.1.8 5 .5 6.2.1 8.1.1 12 .1 12s0 3.9.4 5.8c.3 1.2 1.2 2.1 2.4 2.4 1.9.4 9.1.4 9.1.4s7.2 0 9.1-.4c1.2-.3 2.1-1.2 2.4-2.4.4-1.9.4-5.8.4-5.8s0-3.9-.4-5.8ZM9.9 15.5V8.5l6 3.5-6 3.5Z"/></svg>
                    </a>
                    <a href="#" class="social-link social-facebook" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M13.5 21v-8h2.7l.4-3h-3.1V7.4c0-.9.3-1.6 1.6-1.6h1.7V2.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.1H7v3h2.4v8h4.1Z"/></svg>
                    </a>
                    <a href="https://www.tiktok.com/@alhikmah9675" target="_blank" rel="noopener noreferrer" class="social-link social-tiktok" aria-label="TikTok">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M15.5 3c.3 1.6 1.5 2.9 3.2 3.4v2.3c-1.2-.1-2.3-.5-3.2-1.2v7.2c0 2.7-2.2 4.9-4.9 4.9S6.7 17.3 6.7 14.6 8.9 9.7 11.6 9.7c.4 0 .7.1 1.1.2v2.3c-.4-.1-.7-.2-1.1-.2-1.5 0-2.8 1.2-2.8 2.8s1.2 2.8 2.8 2.8 2.8-1.2 2.8-2.8V3h2.6Z"/></svg>
                    </a>
                    <a href="https://wa.me/2250507674208" target="_blank" rel="noopener noreferrer" class="social-link social-whatsapp" aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M19.1 4.9A9.6 9.6 0 0 0 12.1 2a9.7 9.7 0 0 0-8.4 14.7L2 22l5.4-1.4a9.7 9.7 0 0 0 4.7 1.4h.1a9.6 9.6 0 0 0 6.9-3.3A9.6 9.6 0 0 0 19.1 4.9ZM12.2 18.1h-.1a8 8 0 0 1-4.1-1.1l-.3-.2-3.2.8.9-3.1-.2-.3a8 8 0 1 1 7.1 4.9Zm4.4-6c-.2-.1-1.3-.6-1.5-.7-.2-.1-.4-.1-.5.1-.1.1-.5.7-.6.8-.1.1-.2.1-.4 0-.2-.1-.8-.3-1.6-.9-.6-.5-1-1.1-1.2-1.3-.1-.2 0-.4.1-.5l.2-.2c.1-.1.1-.2.2-.3.1-.1.1-.2.2-.4.1-.1.1-.3 0-.4-.1-.1-.5-1.3-.7-1.8-.2-.5-.4-.4-.5-.4h-.4c-.1 0-.3 0-.5.1-.2.1-.6.6-.9 1.1-.3.6-.7 1.3-.7 2.5s.7 2.9.8 3.1c.1.2 1.4 2.2 3.5 3.1 2.1.9 2.1.6 2.5.5.4-.1 1.3-.5 1.5-1 .2-.5.2-1 .1-1.1-.1-.1-.2-.1-.4-.2Z"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-col footer-commitment">
                <h4>Notre engagement</h4>
                <p>Des actions menées avec respect, proximité et transparence pour un impact durable.</p>
                <a href="/impact" class="footer-text-link">Voir notre impact <span aria-hidden="true">→</span></a>
                <a href="/actualites" class="footer-text-link">Suivre nos actualités <span aria-hidden="true">→</span></a>
                <a href="/admin/login" class="footer-admin-link">Accès équipe</a>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container footer-bottom-inner">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($appConfig['organization']['name']) ?> — Tous droits réservés.</p>
                <p>Éducation · Transmission · Solidarité</p>
            </div>
        </div>
    </footer>

    <!-- Widget Chatbot IA (Innovation 1) -->
    <?php require dirname(__DIR__) . '/partials/chatbot_widget.php'; ?>

    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/chatbot.js"></script>
</body>
</html>
