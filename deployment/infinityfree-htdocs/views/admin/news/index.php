<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Gestion des Actualités & Articles</h2>
</div>

<div class="crm-grid-2col">
    <!-- Liste des articles -->
    <div class="card">
        <h3>Articles Récents</h3>
        <div class="table-responsive">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Auteur</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($articles)): ?>
                        <tr><td colspan="5" class="text-center">Aucun article pour le moment.</td></tr>
                    <?php else: ?>
                        <?php foreach ($articles as $art): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($art['titre']) ?></strong><br>
                                    <?php if (!empty($art['action_titre'])): ?>
                                        <small class="text-muted">Projet : <?= htmlspecialchars($art['action_titre']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $art['statut'] === 'publie' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($art['statut']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($art['auteur_nom'] ?? 'Équipe') ?></td>
                                <td><?= date('d/m/Y', strtotime($art['date_creation'])) ?></td>
                                <td>
                                    <form action="/admin/actualites/supprimer/<?= $art['id'] ?>" method="POST" onsubmit="return confirm('Supprimer cet article ?');">
                                        <?= $csrfField ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Suppr</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formulaire d'ajout d'article -->
    <div class="card">
        <h3>Publier un nouvel Article</h3>
        <form action="/admin/actualites/nouveau" method="POST" class="form-standard">
            <?= $csrfField ?>

            <div class="form-group">
                <label for="titre">Titre de l'actualité *</label>
                <input type="text" name="titre" id="titre" class="form-control" placeholder="Ex: Inauguration du nouveau dispensaire" required>
            </div>

            <div class="form-group">
                <label for="action_id">Lier à un projet (optionnel)</label>
                <select name="action_id" id="action_id" class="form-control">
                    <option value="">Aucun projet lié</option>
                    <?php foreach ($actions as $act): ?>
                        <option value="<?= $act['id'] ?>"><?= htmlspecialchars($act['titre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="statut">Statut de publication</label>
                <select name="statut" id="statut" class="form-control">
                    <option value="publie" selected>Publier immédiatement</option>
                    <option value="brouillon">Enregistrer comme brouillon</option>
                </select>
            </div>

            <div class="form-group">
                <label for="contenu">Contenu de l'article *</label>
                <textarea name="contenu" id="contenu" rows="6" class="form-control" placeholder="Rédigez le texte de votre article..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Enregistrer l'article</button>
        </form>
    </div>
</div>
