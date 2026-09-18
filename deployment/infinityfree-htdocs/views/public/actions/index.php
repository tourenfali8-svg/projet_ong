<div class="page-header">
    <div class="container">
        <h1>Nos Initiatives de Développement & Accompagnement</h1>
        <p>Découvrez les projets et programmes de l'ONG AL HIKMAH qui soutiennent la croissance, la guidance et l'épanouissement des personnes et des communautés.</p>
    </div>
</div>

<div class="container page-content">
    <?php if ($currentFilter === 'terminee'): ?>
        <section class="terminated-gallery-section">
            <div class="section-header">
                <div>
                    <h2>Actions terminées</h2>
                    <p>Quelques réalisations marquantes déjà menées par l'ONG AL HIKMAH.</p>
                </div>
            </div>

            <div class="terminated-gallery-nav">
                <button type="button" class="terminated-gallery-btn terminated-gallery-prev" aria-label="Voir les actions précédentes">‹</button>
                <button type="button" class="terminated-gallery-btn terminated-gallery-next" aria-label="Voir les actions suivantes">›</button>
            </div>

            <div class="terminated-gallery-wrapper">
                <div class="terminated-gallery-track">
                    <article class="terminated-gallery-item">
                        <div class="terminated-gallery-visuals">
                            <img src="/assets/images/affiche-ramadan.jpeg" alt="Ramadan Tafsir 2026 - ONG AL HIKMAH">
                            <img src="/assets/images/lecture-coranique.jpeg" alt="Séance de lecture coranique - ONG AL HIKMAH">
                        </div>
                        <div class="terminated-gallery-content">
                            <span class="terminated-tag">Action terminée</span>
                            <h3>Ramadan Tafsir 2026</h3>
                            <p>
                                Une série de sessions de Tafsir et d’enseignement spirituel organisée à la Mosquée de Cheick Dosso, à Abobo Anador.
                                L’événement a réuni les fidèles autour de la guidance, de la paix et de l’inspiration communautaire.
                            </p>
                        </div>
                    </article>

                    <article class="terminated-gallery-item terminated-gallery-item-video">
                        <video controls preload="metadata" playsinline>
                            <source src="/assets/videos/tafsir-1.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas la lecture de vidéos HTML5.
                        </video>
                        <div class="terminated-gallery-content">
                            <span class="terminated-tag">Vidéo</span>
                            <h3>Moment fort du Tafsir 2026</h3>
                            <p>
                                Cette vidéo peut servir de support visuel pour présenter les moments clés, les enseignements et l’ambiance de cette action communautaire.
                            </p>
                        </div>
                    </article>

                    <article class="terminated-gallery-item terminated-gallery-item-video">
                        <video controls preload="metadata" playsinline>
                            <source src="/assets/videos/nuit-al-qadr-2026.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas la lecture de vidéos HTML5.
                        </video>
                        <div class="terminated-gallery-content">
                            <span class="terminated-tag">Vidéo</span>
                            <h3>Arrivée de l’imam – Nuit d’Al Qadr 2026</h3>
                            <p>
                                Célébration de la nuit d’Al Qadr 2026 avec l’arrivée de l’imam à la mosquée, dans un cadre solennel, spirituel et empreint de sérénité.
                            </p>
                        </div>
                    </article>

                    <article class="terminated-gallery-item terminated-gallery-item-alt">
                        <div class="terminated-gallery-content">
                            <span class="terminated-tag">Impact durable</span>
                            <h3>Transmission des valeurs</h3>
                            <p>
                                Cette action a renforcé les échanges intergénérationnels et soutenu les communautés dans un esprit de solidarité, de respect et d’éducation.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Filtres par statut -->
    <div class="filter-tabs">
        <a href="/actions" class="filter-tab <?= empty($currentFilter) ? 'active' : '' ?>">Toutes les actions</a>
        <a href="/actions?statut=en_cours" class="filter-tab <?= $currentFilter === 'en_cours' ? 'active' : '' ?>">En cours</a>
        <a href="/actions?statut=planifiee" class="filter-tab <?= $currentFilter === 'planifiee' ? 'active' : '' ?>">Planifiées</a>
        <a href="/actions?statut=terminee" class="filter-tab <?= $currentFilter === 'terminee' ? 'active' : '' ?>">Terminées</a>
    </div>

    <!-- Grille des actions -->
    <div class="cards-grid">
        <?php if (empty($actions)): ?>
            <div class="alert alert-info">Aucune action ne correspond à ce filtre actuellement.</div>
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
                        <p class="card-desc"><?= htmlspecialchars(mb_substr($act['description'] ?? '', 0, 120)) ?>...</p>

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
                            <a href="/actions/<?= $act['id'] ?>" class="btn btn-outline btn-block">Consulter</a>
                            <?php if ($act['statut'] !== 'terminee'): ?>
                                <a href="/don?action=<?= $act['id'] ?>" class="btn btn-primary btn-block">Soutenir</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
