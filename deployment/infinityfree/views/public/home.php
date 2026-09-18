<!-- Section Héro -->
<section class="hero-section">
    <div class="container hero-content">
        <span class="hero-badge">Stabiliser, guider, accompagner</span>
        <h1 class="hero-title">Ancré  dans nos racines,guidé par le savoir, unis par l'humanisme : bâtissons un avenir durable</h1>
        <p class="hero-subtitle">
            Grâce à votre soutien, l'ONG AL HIKMAH accompagne les personnes dans leur développement, leur guidance et leur progression spirituelle et sociale, en s'appuyant sur des valeurs ancestrales et un accompagnement humain de proximité.
        </p>
        <div class="hero-actions">
            <a href="/don" class="btn btn-primary btn-lg">Faire un don maintenant</a>
            <a href="/actions" class="btn btn-outline-white btn-lg">Découvrir nos projets</a>
        </div>
        <div class="hero-datetime" aria-live="polite">
            <span class="hero-datetime-label">Nous sommes le</span>
            <strong id="current-date">Chargement de la date...</strong>
            <span class="hero-datetime-separator">|</span>
            <span class="hero-datetime-label">Heure locale</span>
            <strong id="current-time">--:--:--</strong>
        </div>
    </div>
</section>

<!-- Bandeau Besoin Urgent (Innovation 9) s'il y en a -->
<?php if (!empty($urgentNeeds)): ?>
    <div class="urgent-banner">
        <div class="container urgent-banner-inner">
            <div class="urgent-badge-pulse">URGENCE</div>
            <div class="urgent-info">
                <strong><?= htmlspecialchars($urgentNeeds[0]['titre']) ?> :</strong>
                <span><?= htmlspecialchars(mb_substr($urgentNeeds[0]['description'] ?? '', 0, 110)) ?>...</span>
            </div>
            <a href="/don?action=<?= $urgentNeeds[0]['action_id'] ?? '' ?>" class="btn btn-danger btn-sm">Aider maintenant</a>
        </div>
    </div>
<?php endif; ?>

<!-- Chiffres Clés du Tableau d'Impact Public (Innovation 12) -->
<section class="section-impact-kpis">
    <div class="container">
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-value"><?= number_format($impactStats['beneficiaires_aides'], 0, ',', ' ') ?></div>
                <div class="kpi-label">Bénéficiaires Aidés</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-value"><?= number_format($impactStats['fonds_collectes'], 0, ',', ' ') ?> FCFA</div>
                <div class="kpi-label">Fonds Mobilisés</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-value"><?= (int)$impactStats['actions_realisees'] ?></div>
                <div class="kpi-label">Actions sur le Terrain</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-value"><?= (int)$impactStats['zones_couvertes'] ?></div>
                <div class="kpi-label">Zones d'Intervention</div>
            </div>
        </div>
    </div>
</section>

<!-- Section Actions Récentes avec Jauge de Progression (Innovation 3) -->
<section class="section-actions">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Besoins urgents & initiatives prioritaires</h2>
                <p>Découvrez les actions concrètes menées par l'ONG AL HIKMAH pour répondre aux besoins les plus pressants, soutenir les personnes en difficulté et renforcer leur développement.</p>
            </div>
            <a href="/actions" class="link-more">Voir toutes les actions →</a>
        </div>

        <div class="cards-grid">
            <?php if (empty($actions)): ?>
                <p>Aucune action en cours pour le moment.</p>
            <?php else: ?>
                <?php foreach ($actions as $act): ?>
                    <div class="action-card">
                        <div class="card-image-wrapper">
                            <span class="status-pill status-<?= htmlspecialchars($act['statut']) ?>">
                                <?= ucfirst(str_replace('_', ' ', $act['statut'])) ?>
                            </span>
                            <div class="card-image-placeholder">
                                <span>📍 <?= htmlspecialchars($act['zone_ville'] ?? 'Afrique de l\'Ouest') ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($act['titre']) ?></h3>
                            <p class="card-desc"><?= htmlspecialchars(mb_substr($act['description'] ?? '', 0, 110)) ?>...</p>
                            
                            <!-- Jauge de progression en temps réel (Innovation 3) -->
                            <div class="progress-block">
                                <div class="progress-stats">
                                    <strong><?= number_format($act['montant_collecte'], 0, ',', ' ') ?> FCFA</strong>
                                    <span>sur <?= number_format($act['objectif_financier'], 0, ',', ' ') ?> FCFA</span>
                                </div>
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" style="width: <?= min(100, $act['pourcentage_collecte']) ?>%;"></div>
                                </div>
                                <div class="progress-pct"><?= $act['pourcentage_collecte'] ?>% financé</div>
                            </div>

                            <div class="card-footer-action">
                                <a href="/actions/<?= $act['id'] ?>" class="btn btn-outline btn-block">Voir le projet</a>
                                <a href="/don?action=<?= $act['id'] ?>" class="btn btn-primary btn-block">Soutenir</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Section Dernières Actualités -->
<section class="section-news">
    <div class="container">
        <div class="section-header">
            <div>
                <h2>Actualités & Messages de Guidance</h2>
                <p>Suivez les avancées, les enseignements et les initiatives qui accompagnent les personnes sur leur chemin.</p>
            </div>
            <a href="/actualites" class="link-more">Toutes les actualités →</a>
        </div>

        <div class="cards-grid">
            <?php foreach ($news as $article): ?>
                <div class="news-card">
                    <div class="news-date">📅 <?= date('d/m/Y', strtotime($article['date_publication'] ?? $article['date_creation'])) ?></div>
                    <h3><a href="/actualites/<?= $article['id'] ?>"><?= htmlspecialchars($article['titre']) ?></a></h3>
                    <p><?= htmlspecialchars(mb_substr(strip_tags($article['contenu']), 0, 120)) ?>...</p>
                    <a href="/actualites/<?= $article['id'] ?>" class="read-more">Lire l'article →</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
