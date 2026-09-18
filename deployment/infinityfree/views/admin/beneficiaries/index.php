<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Gestion des Bénéficiaires & Communautés</h2>
</div>

<div class="crm-grid-2col">
    <!-- Liste des bénéficiaires -->
    <div class="card">
        <h3>Bénéficiaires Répertoriés</h3>
        <div class="table-responsive">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Nom / Communauté</th>
                        <th>Zone</th>
                        <th>Besoins Exprimés</th>
                        <th>Actions Liées</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($beneficiaries)): ?>
                        <tr><td colspan="4" class="text-center">Aucun bénéficiaire enregistré.</td></tr>
                    <?php else: ?>
                        <?php foreach ($beneficiaries as $b): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($b['nom']) ?></strong></td>
                                <td><?= htmlspecialchars($b['zone_ville'] ?? '-') ?></td>
                                <td><small><?= htmlspecialchars($b['besoins'] ?? '-') ?></small></td>
                                <td><span class="badge badge-primary"><?= (int)$b['total_actions'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulaire d'ajout -->
    <div class="card">
        <h3>Ajouter un Bénéficiaire</h3>
        <form action="/admin/beneficiaires/nouveau" method="POST" class="form-standard">
            <?= $csrfField ?>

            <div class="form-group">
                <label for="nom">Nom de la personne ou communauté *</label>
                <input type="text" name="nom" id="nom" class="form-control" placeholder="Ex: École primaire N'Gattakro ou Famille Traoré" required>
            </div>

            <div class="form-group">
                <label for="zone_id">Zone géographique</label>
                <select name="zone_id" id="zone_id" class="form-control">
                    <option value="">Sélectionnez une zone...</option>
                    <?php foreach ($zones as $z): ?>
                        <option value="<?= $z['id'] ?>"><?= htmlspecialchars($z['nom']) ?> (<?= htmlspecialchars($z['ville']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="besoins">Besoins prioritaires</label>
                <textarea name="besoins" id="besoins" rows="3" class="form-control" placeholder="Ex: Eau potable, kits scolaires, soins d'urgence..."></textarea>
            </div>

            <div class="form-group">
                <label for="informations">Informations complémentaires</label>
                <textarea name="informations" id="informations" rows="2" class="form-control" placeholder="Contacts du chef de village ou référent local..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Enregistrer le bénéficiaire</button>
        </form>
    </div>
</div>
