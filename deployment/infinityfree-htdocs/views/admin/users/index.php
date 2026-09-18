<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Gestion des Comptes & Droits d'Accès du CRM</h2>
</div>

<div class="crm-grid-2col">
    <!-- Liste des utilisateurs -->
    <div class="card">
        <h3>Utilisateurs du CRM</h3>
        <div class="table-responsive">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Nom & Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><span class="user-role-tag"><?= htmlspecialchars($u['role_nom']) ?></span></td>
                            <td>
                                <span class="badge badge-<?= $u['statut'] === 'actif' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($u['statut']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulaire d'ajout d'utilisateur -->
    <div class="card">
        <h3>Créer un Compte Collaborateur</h3>
        <form action="/admin/utilisateurs/nouveau" method="POST" class="form-standard">
            <?= $csrfField ?>

            <div class="form-row">
                <div class="form-group col-half">
                    <label for="nom">Nom *</label>
                    <input type="text" name="nom" id="nom" class="form-control" required>
                </div>
                <div class="form-group col-half">
                    <label for="prenom">Prénom *</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Adresse Email *</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="collaborateur@espoir-avenir.ong" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" name="telephone" id="telephone" class="form-control">
            </div>

            <div class="form-group">
                <label for="role_id">Rôle attribué *</label>
                <select name="role_id" id="role_id" class="form-control" required>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nom']) ?> — <?= htmlspecialchars($r['description']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe temporaire *</label>
                <input type="password" name="password" id="password" class="form-control" minlength="6" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Créer le compte utilisateur</button>
        </form>
    </div>
</div>
