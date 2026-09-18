<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Suivi des Dons & Transactions Financières</h2>
    <a href="/admin/exports/dons" class="btn btn-outline btn-sm">📥 Exporter en CSV</a>
</div>

<!-- Filtres par statut de transaction -->
<div class="filter-tabs" style="margin-bottom: 20px;">
    <a href="/admin/dons" class="filter-tab <?= empty($currentFilter) ? 'active' : '' ?>">Tous les dons</a>
    <a href="/admin/dons?statut=confirme" class="filter-tab <?= $currentFilter === 'confirme' ? 'active' : '' ?>">Confirmés</a>
    <a href="/admin/dons?statut=en_attente" class="filter-tab <?= $currentFilter === 'en_attente' ? 'active' : '' ?>">En attente</a>
    <a href="/admin/dons?statut=echoue" class="filter-tab <?= $currentFilter === 'echoue' ? 'active' : '' ?>">Échoués</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>Réf. Transac.</th>
                    <th>Donateur</th>
                    <th>Téléphone</th>
                    <th>Action Affectée</th>
                    <th>Montant</th>
                    <th>Type</th>
                    <th>Moyen</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($donations)): ?>
                    <tr><td colspan="9" class="text-center">Aucun don répertorié pour ce filtre.</td></tr>
                <?php else: ?>
                    <?php foreach ($donations as $d): ?>
                        <tr>
                            <td><code><?= htmlspecialchars($d['reference_transaction'] ?? '-') ?></code></td>
                            <td>
                                <strong><?= htmlspecialchars($d['donateur_prenom'] . ' ' . $d['donateur_nom']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($d['donateur_telephone']) ?></td>
                            <td><?= htmlspecialchars($d['action_titre'] ?? 'Fonds général') ?></td>
                            <td><strong class="text-success"><?= number_format($d['montant'], 0, ',', ' ') ?> F</strong></td>
                            <td><span class="badge"><?= ucfirst($d['type_don']) ?></span></td>
                            <td><?= strtoupper($d['operateur_paiement'] ?? '-') ?></td>
                            <td>
                                <span class="badge badge-<?= $d['transaction_statut'] === 'confirme' ? 'success' : ($d['transaction_statut'] === 'echoue' ? 'danger' : 'warning') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $d['transaction_statut'] ?? 'En attente')) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($d['date_don'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
