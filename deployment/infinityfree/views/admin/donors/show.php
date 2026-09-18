<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Fiche Donateur : <?= htmlspecialchars($donor['prenom'] . ' ' . $donor['nom']) ?></h2>
    <a href="/admin/donateurs" class="btn btn-outline">← Retour à la liste</a>
</div>

<div class="crm-grid-2col">
    <!-- Profil & Fidélité -->
    <div class="card">
        <h3>Informations Personnelles</h3>
        <p><strong>Téléphone :</strong> <?= htmlspecialchars($donor['telephone']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($donor['email'] ?? 'Non renseigné') ?></p>
        <p><strong>Adresse :</strong> <?= htmlspecialchars($donor['adresse'] ?? 'Non renseignée') ?></p>
        <p><strong>Date d'inscription :</strong> <?= date('d/m/Y H:i', strtotime($donor['date_creation'])) ?></p>

        <hr style="margin: 20px 0;">

        <h3>Statut de Fidélisation (Innovation 6)</h3>
        <p>
            <strong>Niveau actuel :</strong> 
            <span class="badge-tier tier-<?= strtolower($donor['niveau']['nom'] ?? 'bronze') ?>">
                <?= htmlspecialchars($donor['niveau']['nom'] ?? 'Bronze') ?>
            </span>
        </p>
        <p><strong>Points cumulés :</strong> <?= (int)$donor['points_fidelite'] ?> points</p>

        <?php if (!empty($donor['badges'])): ?>
            <h4>Badges attribués :</h4>
            <div class="badges-row">
                <?php foreach ($donor['badges'] as $b): ?>
                    <div class="badge-chip">
                        🏅 <strong><?= htmlspecialchars($b['nom']) ?></strong>
                        <br><small><?= htmlspecialchars($b['description']) ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Historique des dons -->
    <div class="card">
        <h3>Historique des Dons Reçus</h3>
        <?php if (empty($donor['dons'])): ?>
            <p>Aucun don enregistré.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="crm-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Action</th>
                            <th>Opérateur</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donor['dons'] as $d): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($d['date_don'])) ?></td>
                                <td><strong><?= number_format($d['montant'], 0, ',', ' ') ?> F</strong></td>
                                <td><?= htmlspecialchars($d['action_titre'] ?? 'Fonds général') ?></td>
                                <td><?= strtoupper($d['operateur_paiement'] ?? '-') ?></td>
                                <td>
                                    <span class="badge badge-<?= $d['statut_transaction'] === 'confirme' ? 'success' : 'warning' ?>">
                                        <?= ucfirst(str_replace('_', ' ', $d['statut_transaction'] ?? 'En attente')) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
