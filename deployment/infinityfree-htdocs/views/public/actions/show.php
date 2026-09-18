<div class="page-header">
    <div class="container">
        <span class="status-pill status-<?= htmlspecialchars($action['statut']) ?>">
            <?= ucfirst(str_replace('_', ' ', $action['statut'])) ?>
        </span>
        <h1><?= htmlspecialchars($action['titre']) ?></h1>
        <p>📍 Zone : <?= htmlspecialchars(($action['zone']['nom'] ?? '') . ' (' . ($action['zone']['ville'] ?? '') . ', ' . ($action['zone']['pays'] ?? '') . ')') ?></p>
    </div>
</div>

<div class="container page-content">
    <div class="action-detail-layout">
        <!-- Colonne Principale -->
        <div class="action-main">
            <div class="action-description card">
                <h2>Description du Projet</h2>
                <p><?= nl2br(htmlspecialchars($action['description'] ?? '')) ?></p>
            </div>

            <!-- Photos Avant / Après (Innovation 7 : Suivi d'impact) -->
            <?php if (!empty($action['photos'])): ?>
                <div class="card" style="margin-top: 25px;">
                    <h2>Photos du Terrain — Suivi d'Impact (Avant / Après)</h2>
                    <div class="photos-grid">
                        <?php foreach ($action['photos'] as $photo): ?>
                            <div class="photo-item">
                                <span class="photo-badge type-<?= htmlspecialchars($photo['type_photo']) ?>">
                                    <?= strtoupper($photo['type_photo']) ?>
                                </span>
                                <div class="photo-placeholder">
                                    📷 <?= htmlspecialchars($photo['legende'] ?? 'Photo du projet') ?>
                                </div>
                                <p class="photo-caption"><?= htmlspecialchars($photo['legende'] ?? '') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Bénéficiaires concernés -->
            <?php if (!empty($action['beneficiaires'])): ?>
                <div class="card" style="margin-top: 25px;">
                    <h2>Communautés & Bénéficiaires Concernés</h2>
                    <ul class="beneficiaries-list">
                        <?php foreach ($action['beneficiaires'] as $ben): ?>
                            <li>
                                <strong><?= htmlspecialchars($ben['nom']) ?> :</strong>
                                <span><?= htmlspecialchars($ben['besoins'] ?? '') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Rapport d'impact final si terminé -->
            <?php if (!empty($action['rapport_impact'])): ?>
                <div class="card card-impact" style="margin-top: 25px;">
                    <h2>📊 Rapport d'Impact & Résultats Obtenus</h2>
                    <div class="impact-metrics-row">
                        <div>
                            <strong><?= number_format($action['rapport_impact']['nombre_beneficiaires_aides'], 0, ',', ' ') ?></strong>
                            <span>Personnes Aidées</span>
                        </div>
                        <div>
                            <strong><?= number_format($action['rapport_impact']['montant_utilise'], 0, ',', ' ') ?> FCFA</strong>
                            <span>Fonds Investis</span>
                        </div>
                    </div>
                    <p><strong>Résultats :</strong> <?= nl2br(htmlspecialchars($action['rapport_impact']['resultats_obtenus'] ?? '')) ?></p>
                    <?php if (!empty($action['rapport_impact']['temoignages'])): ?>
                        <blockquote>"<?= htmlspecialchars($action['rapport_impact']['temoignages']) ?>"</blockquote>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Colonne Latérale : Financement & Don -->
        <aside class="action-sidebar">
            <div class="card card-donation-box sticky-box">
                <h3>Objectif de Financement</h3>
                <div class="progress-block" style="margin: 20px 0;">
                    <div class="progress-stats">
                        <strong><?= number_format($action['montant_collecte'], 0, ',', ' ') ?> FCFA</strong>
                        <span>Objectif : <?= number_format($action['objectif_financier'], 0, ',', ' ') ?> FCFA</span>
                    </div>
                    <div class="progress-bar-bg" style="height: 12px;">
                        <div class="progress-bar-fill" style="width: <?= min(100, $action['pourcentage_collecte']) ?>%;"></div>
                    </div>
                    <div class="progress-pct" style="font-size: 1.1rem; font-weight: bold; margin-top: 8px;">
                        <?= $action['pourcentage_collecte'] ?>% réalisé
                    </div>
                </div>

                <div class="project-meta-list">
                    <div>📅 <strong>Début :</strong> <?= $action['date_debut'] ? date('d/m/Y', strtotime($action['date_debut'])) : 'Non spécifié' ?></div>
                    <div>🏁 <strong>Fin estimée :</strong> <?= $action['date_fin'] ? date('d/m/Y', strtotime($action['date_fin'])) : 'Non spécifiée' ?></div>
                </div>

                <hr style="margin: 20px 0;">

                <a href="/don?action=<?= $action['id'] ?>" class="btn btn-primary btn-lg btn-block">
                    Faire un don pour cette action
                </a>
                <p class="text-muted text-center" style="font-size: 0.85rem; margin-top: 10px;">
                    Paiement 100% sécurisé via Wave, Orange Money, MTN ou Moov.
                </p>
            </div>
        </aside>
    </div>
</div>
