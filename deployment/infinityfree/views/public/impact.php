<div class="page-header">
    <div class="container">
        <h1>Transparence & Impact Public</h1>
        <p>Découvrez concrètement l'utilisation des fonds collectés et les résultats mesurables de nos interventions humanitaires.</p>
    </div>
</div>

<div class="container page-content">
    <!-- 1. Grands indicateurs clés (Vue SQL vue_impact_public) -->
    <div class="kpi-grid" style="margin-bottom: 40px;">
        <div class="kpi-card">
            <div class="kpi-value"><?= number_format($stats['beneficiaires_aides'], 0, ',', ' ') ?></div>
            <div class="kpi-label">Vies Impactées & Aidées</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value"><?= number_format($stats['fonds_collectes'], 0, ',', ' ') ?> FCFA</div>
            <div class="kpi-label">Fonds Totaux Mobilisés</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value"><?= (int)$stats['actions_realisees'] ?></div>
            <div class="kpi-label">Actions Réalisées ou en cours</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value"><?= (int)$stats['zones_couvertes'] ?></div>
            <div class="kpi-label">Zones Géographiques</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-value"><?= (int)$stats['projets_termines'] ?></div>
            <div class="kpi-label">Projets Conclus avec Succès</div>
        </div>
    </div>

    <!-- 2. Carte interactive des zones d'actions (Innovation 4) -->
    <section class="card" style="margin-bottom: 40px;">
        <h2>🗺️ Carte Interactive de nos Interventions</h2>
        <p>Explorez les zones couvertes par l'ONG, visualisez les actions locales et le nombre de bénéficiaires soutenus.</p>
        
        <div class="zones-interactive-grid">
            <div class="zones-map-box">
                <div class="map-visual-container" id="map-container">
                    <div class="map-overlay-pin-container">
                        <?php foreach ($zones as $index => $z): ?>
                            <div class="zone-pin" style="top: <?= 20 + ($index * 15) % 65 ?>%; left: <?= 25 + ($index * 22) % 65 ?>%;" 
                                 onclick="selectZone(<?= htmlspecialchars(json_encode($z)) ?>)">
                                📍 <?= htmlspecialchars($z['ville']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="zones-detail-box" id="zone-detail-panel">
                <h3>Sélectionnez une zone</h3>
                <p>Cliquez sur un marqueur géographique pour inspecter les actions et les besoins spécifiques de cette région.</p>
            </div>
        </div>
    </section>

    <!-- 3. Rapports d'Impact & Témoignages récents (Innovation 7) -->
    <section>
        <div class="section-header">
            <h2>Rapports de Fin de Projet & Témoignages</h2>
            <p>Ce que vos dons changent au quotidien dans la vie des communautés.</p>
        </div>

        <div class="cards-grid">
            <?php if (empty($reports)): ?>
                <div class="alert alert-info">Les premiers rapports d'impact consolidés sont en cours de rédaction par nos équipes terrain.</div>
            <?php else: ?>
                <?php foreach ($reports as $rep): ?>
                    <div class="card impact-report-card">
                        <span class="badge-tag">🎯 <?= htmlspecialchars($rep['action_titre']) ?></span>
                        <div class="impact-report-stats">
                            <div>
                                <strong><?= number_format($rep['nombre_beneficiaires_aides'], 0, ',', ' ') ?></strong>
                                <span>Personnes aidées</span>
                            </div>
                            <div>
                                <strong><?= number_format($rep['montant_utilise'], 0, ',', ' ') ?> FCFA</strong>
                                <span>Fonds utilisés</span>
                            </div>
                        </div>
                        <h4>Résultats concrets</h4>
                        <p><?= nl2br(htmlspecialchars($rep['resultats_obtenus'])) ?></p>
                        <?php if (!empty($rep['temoignages'])): ?>
                            <blockquote class="report-quote">"<?= htmlspecialchars($rep['temoignages']) ?>"</blockquote>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
function selectZone(zone) {
    const panel = document.getElementById('zone-detail-panel');
    let actionsHtml = '';
    if (zone.actions && zone.actions.length > 0) {
        actionsHtml = '<ul class="zone-actions-list">' + zone.actions.map(a => 
            `<li><strong>${a.titre}</strong> (${a.statut}) — Collecté : ${Number(a.montant_collecte).toLocaleString('fr-FR')} FCFA</li>`
        ).join('') + '</ul>';
    } else {
        actionsHtml = '<p>Aucune action active actuellement dans cette zone.</p>';
    }

    panel.innerHTML = `
        <h3>📍 ${zone.nom} (${zone.ville}, ${zone.pays})</h3>
        <p><strong>Bénéficiaires identifiés :</strong> ${zone.total_beneficiaires}</p>
        <h4>Actions dans cette zone :</h4>
        ${actionsHtml}
        <a href="/don" class="btn btn-primary btn-sm btn-block" style="margin-top:15px;">Soutenir cette zone</a>
    `;
}
</script>
