<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Candidatures de Bénévolat Reçues</h2>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>Bénévole</th>
                    <th>Téléphone / WhatsApp</th>
                    <th>Email</th>
                    <th>Mission Ciblée</th>
                    <th>Compétences Déclarées</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($applications)): ?>
                    <tr><td colspan="7" class="text-center">Aucune candidature enregistrée pour le moment.</td></tr>
                <?php else: ?>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($app['benevole_prenom'] . ' ' . $app['benevole_nom']) ?></strong></td>
                            <td><?= htmlspecialchars($app['benevole_telephone']) ?></td>
                            <td><?= htmlspecialchars($app['benevole_email'] ?? '-') ?></td>
                            <td>
                                <strong><?= htmlspecialchars($app['mission_titre']) ?></strong><br>
                                <small class="text-muted">📍 <?= htmlspecialchars($app['mission_lieu'] ?? 'Terrain') ?></small>
                            </td>
                            <td><small><?= htmlspecialchars($app['competences'] ?? '-') ?></small></td>
                            <td><?= date('d/m/Y', strtotime($app['date_candidature'])) ?></td>
                            <td>
                                <span class="badge badge-<?= $app['statut'] === 'acceptee' ? 'success' : ($app['statut'] === 'refusee' ? 'danger' : 'warning') ?>">
                                    <?= ucfirst(str_replace('_', ' ', $app['statut'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
