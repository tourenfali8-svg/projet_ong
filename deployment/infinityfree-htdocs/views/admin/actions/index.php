<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Gestion des Actions & Projets Humanitaires</h2>
    <a href="/admin/actions/nouveau" class="btn btn-primary">+ Créer une Action</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre de l'action</th>
                    <th>Zone</th>
                    <th>Statut</th>
                    <th>Objectif (FCFA)</th>
                    <th>Collecté</th>
                    <th>Progression</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($actions)): ?>
                    <tr><td colspan="8" class="text-center">Aucune action enregistrée.</td></tr>
                <?php else: ?>
                    <?php foreach ($actions as $act): ?>
                        <tr>
                            <td>#<?= $act['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars($act['titre']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($act['zone_ville'] ?? 'Non assignée') ?></td>
                            <td>
                                <span class="badge badge-<?= $act['statut'] === 'terminee' ? 'success' : ($act['statut'] === 'en_cours' ? 'primary' : 'secondary') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $act['statut'])) ?>
                                </span>
                            </td>
                            <td><?= number_format($act['objectif_financier'], 0, ',', ' ') ?> F</td>
                            <td><strong><?= number_format($act['montant_collecte'], 0, ',', ' ') ?> F</strong></td>
                            <td>
                                <div class="progress-bar-bg" style="width: 100px; display: inline-block;">
                                    <div class="progress-bar-fill" style="width: <?= min(100, $act['pourcentage_collecte']) ?>%;"></div>
                                </div>
                                <small><?= $act['pourcentage_collecte'] ?>%</small>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="/actions/<?= $act['id'] ?>" target="_blank" class="btn btn-outline btn-sm">Voir</a>
                                    <form action="/admin/actions/supprimer/<?= $act['id'] ?>" method="POST" onsubmit="return confirm('Confirmer la suppression de cette action ?');">
                                        <?= $csrfField ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
