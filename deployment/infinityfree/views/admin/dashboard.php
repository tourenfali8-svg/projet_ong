<!-- Statistiques Clés (Vue SQL vue_tableau_bord) -->
<div class="crm-kpi-grid">
    <div class="crm-kpi-card">
        <div class="kpi-title">Montant Total Collecté</div>
        <div class="kpi-num text-success"><?= number_format($kpis['montant_total_collecte'], 0, ',', ' ') ?> FCFA</div>
        <div class="kpi-sub">Fonds confirmés reçus</div>
    </div>
    <div class="crm-kpi-card">
        <div class="kpi-title">Nombre de Donateurs</div>
        <div class="kpi-num"><?= (int)$kpis['nombre_donateurs'] ?></div>
        <div class="kpi-sub">Donateurs uniques</div>
    </div>
    <div class="crm-kpi-card">
        <div class="kpi-title">Total des Dons</div>
        <div class="kpi-num"><?= (int)$kpis['nombre_dons'] ?></div>
        <div class="kpi-sub"><?= (int)$kpis['transactions_confirmees'] ?> confirmés</div>
    </div>
    <div class="crm-kpi-card">
        <div class="kpi-title">Actions Humanitaires</div>
        <div class="kpi-num"><?= (int)$kpis['nombre_actions'] ?></div>
        <div class="kpi-sub">Campagnes répertoriées</div>
    </div>
</div>

<div class="crm-grid-2col" style="margin-top: 30px;">
    <!-- Derniers Dons & Paiements -->
    <div class="crm-panel card">
        <div class="panel-header">
            <h3>Dernières Transactions Reçues</h3>
            <a href="/admin/dons" class="btn btn-outline btn-sm">Voir tout</a>
        </div>
        <div class="table-responsive">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Donateur</th>
                        <th>Montant</th>
                        <th>Opérateur</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentDonations)): ?>
                        <tr><td colspan="5" class="text-center">Aucun don enregistré pour l'instant.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentDonations as $d): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($d['donateur_prenom'] . ' ' . $d['donateur_nom']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($d['donateur_telephone']) ?></small>
                                </td>
                                <td><strong><?= number_format($d['montant'], 0, ',', ' ') ?> F</strong></td>
                                <td><?= strtoupper($d['operateur_paiement'] ?? 'WAVE') ?></td>
                                <td>
                                    <span class="badge badge-<?= $d['transaction_statut'] === 'confirme' ? 'success' : ($d['transaction_statut'] === 'echoue' ? 'danger' : 'warning') ?>">
                                        <?= ucfirst(str_replace('_', ' ', $d['transaction_statut'] ?? 'En attente')) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m H:i', strtotime($d['date_don'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions et Avancement -->
    <div class="crm-panel card">
        <div class="panel-header">
            <h3>Avancement des Projets</h3>
            <a href="/admin/actions/nouveau" class="btn btn-primary btn-sm">+ Nouvelle Action</a>
        </div>
        <div class="actions-progress-list">
            <?php if (empty($actions)): ?>
                <p>Aucune action créée.</p>
            <?php else: ?>
                <?php foreach ($actions as $act): ?>
                    <div class="action-progress-item">
                        <div class="action-progress-meta">
                            <strong><?= htmlspecialchars($act['titre']) ?></strong>
                            <span><?= number_format($act['montant_collecte'], 0, ',', ' ') ?> / <?= number_format($act['objectif_financier'], 0, ',', ' ') ?> FCFA</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: <?= min(100, $act['pourcentage_collecte']) ?>%;"></div>
                        </div>
                        <div class="action-progress-sub">
                            <small>Statut: <?= ucfirst(str_replace('_', ' ', $act['statut'])) ?></small>
                            <small><?= $act['pourcentage_collecte'] ?>%</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
