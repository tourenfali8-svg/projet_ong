<div class="page-header header-urgent">
    <div class="container">
        <span class="badge-urgent-top">🚨 ALERTE & RÉPONSE RAPIDE</span>
        <h1>Espace Besoins Urgents</h1>
        <p>Face aux crises imprévues, aux inondations ou aux ruptures d'approvisionnement en eau, votre soutien rapide sauve des vies.</p>
    </div>
</div>

<div class="container page-content">
    <?php if (empty($urgentNeeds)): ?>
        <div class="alert alert-success text-center">
            Aucun besoin urgent critique n'est actuellement signalé. Toutes nos actions de terrain régulières se poursuivent normalement.
        </div>
    <?php else: ?>
        <div class="urgent-cards-list">
            <?php foreach ($urgentNeeds as $need): ?>
                <div class="urgent-card level-<?= htmlspecialchars($need['niveau_urgence']) ?>">
                    <div class="urgent-card-header">
                        <div class="urgent-level-tag">
                            Urgence : <?= strtoupper($need['niveau_urgence']) ?>
                        </div>
                        <div class="urgent-location">
                            📍 <?= htmlspecialchars(($need['zone_ville'] ?? '') . ', ' . ($need['zone_pays'] ?? '')) ?>
                        </div>
                    </div>

                    <div class="urgent-card-body">
                        <h2><?= htmlspecialchars($need['titre']) ?></h2>
                        <p><?= nl2br(htmlspecialchars($need['description'] ?? '')) ?></p>

                        <div class="urgent-stats-row">
                            <?php if (!empty($need['nombre_personnes_concernees'])): ?>
                                <div class="stat-pill">
                                    👥 <strong><?= number_format($need['nombre_personnes_concernees'], 0, ',', ' ') ?></strong> personnes touchées
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($need['besoin_financier'])): ?>
                                <div class="stat-pill">
                                    💰 Besoin estimé : <strong><?= number_format($need['besoin_financier'], 0, ',', ' ') ?> FCFA</strong>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="urgent-card-footer">
                        <a href="/don?action=<?= $need['action_id'] ?? '' ?>&affectation=<?= urlencode('Urgence: ' . $need['titre']) ?>" class="btn btn-danger btn-lg">
                            🚨 Aider immédiatement
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
