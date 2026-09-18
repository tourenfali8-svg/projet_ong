<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Gestion des Donateurs & Niveaux de Fidélité</h2>
    <a href="/admin/exports/donateurs" class="btn btn-outline btn-sm">📥 Exporter en CSV</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom & Prénom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Niveau Fidélité</th>
                    <th>Points</th>
                    <th>Total Dons</th>
                    <th>Montant Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($donors)): ?>
                    <tr><td colspan="9" class="text-center">Aucun donateur répertorié.</td></tr>
                <?php else: ?>
                    <?php foreach ($donors as $d): ?>
                        <tr>
                            <td>#<?= $d['id'] ?></td>
                            <td><strong><?= htmlspecialchars($d['prenom'] . ' ' . $d['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($d['telephone']) ?></td>
                            <td><?= htmlspecialchars($d['email'] ?? '-') ?></td>
                            <td>
                                <span class="badge-tier tier-<?= strtolower($d['niveau_nom'] ?? 'bronze') ?>">
                                    <?= htmlspecialchars($d['niveau_nom'] ?? 'Bronze') ?>
                                </span>
                            </td>
                            <td><strong><?= (int)$d['points_fidelite'] ?> pts</strong></td>
                            <td><?= (int)$d['total_dons'] ?> don(s)</td>
                            <td><strong class="text-success"><?= number_format($d['total_montant_donne'], 0, ',', ' ') ?> F</strong></td>
                            <td>
                                <a href="/admin/donateurs/<?= $d['id'] ?>" class="btn btn-outline btn-sm">Fiche</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
