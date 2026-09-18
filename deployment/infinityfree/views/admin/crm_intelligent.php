<div class="panel-header" style="margin-bottom: 25px;">
    <div>
        <h2>🧠 CRM Intelligent & Analyses Prédictives</h2>
        <p>Détection proactive des donateurs clés, relance des inactifs et performances financières par campagne.</p>
    </div>
</div>

<div class="crm-grid-2col">
    <!-- 1. Donateurs Réguliers (Vue SQL vue_donateurs_reguliers) -->
    <div class="card">
        <div class="panel-header">
            <h3>🌟 Donateurs Réguliers & Engagés (>= 3 dons)</h3>
            <span class="badge badge-success"><?= count($regularDonors) ?> Donateurs</span>
        </div>
        <p class="text-muted">Profils fidèles à valoriser et remercier prioritairement.</p>
        
        <div class="table-responsive">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Donateur</th>
                        <th>Téléphone</th>
                        <th>Nombre de dons</th>
                        <th>Montant Cumulé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($regularDonors)): ?>
                        <tr><td colspan="4" class="text-center">Aucun donateur régulier identifié pour le moment.</td></tr>
                    <?php else: ?>
                        <?php foreach ($regularDonors as $rd): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($rd['prenom'] . ' ' . $rd['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($rd['telephone']) ?></td>
                                <td><span class="badge badge-primary"><?= (int)$rd['nombre_dons'] ?> dons</span></td>
                                <td><strong class="text-success"><?= number_format($rd['montant_total'], 0, ',', ' ') ?> F</strong></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Donateurs Inactifs (Vue SQL vue_donateurs_inactifs) -->
    <div class="card">
        <div class="panel-header">
            <h3>⚠️ Donateurs Inactifs (> 6 mois sans don)</h3>
            <span class="badge badge-warning"><?= count($inactiveDonors) ?> Inactifs</span>
        </div>
        <p class="text-muted">Cibles prioritaires pour campagnes de relance SMS ou WhatsApp.</p>

        <div class="table-responsive">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Donateur</th>
                        <th>Dernier Don</th>
                        <th>Action suggérée</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inactiveDonors)): ?>
                        <tr><td colspan="3" class="text-center">Aucun donateur inactif détecté.</td></tr>
                    <?php else: ?>
                        <?php foreach ($inactiveDonors as $id): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($id['prenom'] . ' ' . $id['nom']) ?></strong></td>
                                <td><?= $id['dernier_don'] ? date('d/m/Y', strtotime($id['dernier_don'])) : 'Jamais' ?></td>
                                <td>
                                    <a href="https://wa.me/?text=Bonjour%20nous%20vous%20partageons%20nos%20derniers%20rapports%20d'impact" target="_blank" class="btn btn-outline btn-sm">
                                        Relance WhatsApp
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 3. Performance des Campagnes (Vue SQL vue_performance_actions) -->
<div class="card" style="margin-top: 30px;">
    <h3>🎯 Performance Financière des Campagnes</h3>
    <div class="table-responsive">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Objectif</th>
                    <th>Montant Récolté Réel</th>
                    <th>Donateurs Uniques</th>
                    <th>Taux d'Atteinte</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($campaignPerformance)): ?>
                    <tr><td colspan="5" class="text-center">Aucune donnée disponible.</td></tr>
                <?php else: ?>
                    <?php foreach ($campaignPerformance as $cp): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($cp['titre']) ?></strong></td>
                            <td><?= number_format($cp['objectif_financier'], 0, ',', ' ') ?> F</td>
                            <td><strong class="text-success"><?= number_format($cp['montant_collecte_reel'], 0, ',', ' ') ?> F</strong></td>
                            <td><?= (int)$cp['nombre_donateurs'] ?></td>
                            <td>
                                <div class="progress-bar-bg" style="width: 120px; display: inline-block;">
                                    <div class="progress-bar-fill" style="width: <?= min(100, $cp['pourcentage_atteint']) ?>%;"></div>
                                </div>
                                <strong><?= $cp['pourcentage_atteint'] ?>%</strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
