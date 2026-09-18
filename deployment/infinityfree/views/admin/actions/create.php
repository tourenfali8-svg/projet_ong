<div class="panel-header" style="margin-bottom: 25px;">
    <h2>Créer une nouvelle Action Humanitaire</h2>
    <a href="/admin/actions" class="btn btn-outline">← Retour à la liste</a>
</div>

<div class="card" style="max-width: 800px;">
    <form action="/admin/actions/nouveau" method="POST" class="form-standard">
        <?= $csrfField ?>

        <div class="form-group">
            <label for="titre">Titre du Projet / Action *</label>
            <input type="text" name="titre" id="titre" class="form-control" placeholder="Ex: Forage d'eau potable village N'Gattakro" required>
        </div>

        <div class="form-group">
            <label for="description">Description détaillée du projet</label>
            <textarea name="description" id="description" rows="5" class="form-control" placeholder="Objectifs, contexte, communauté bénéficiaire..."></textarea>
        </div>

        <div class="form-row">
            <div class="form-group col-half">
                <label for="zone_id">Zone géographique</label>
                <select name="zone_id" id="zone_id" class="form-control">
                    <option value="">Sélectionner une zone...</option>
                    <?php foreach ($zones as $z): ?>
                        <option value="<?= $z['id'] ?>"><?= htmlspecialchars($z['nom']) ?> (<?= htmlspecialchars($z['ville']) ?>, <?= htmlspecialchars($z['pays']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-half">
                <label for="statut">Statut initial</label>
                <select name="statut" id="statut" class="form-control">
                    <option value="planifiee" selected>Planifiée</option>
                    <option value="en_cours">En cours</option>
                    <option value="terminee">Terminée</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="objectif_financier">Objectif Financier (FCFA) *</label>
            <input type="number" name="objectif_financier" id="objectif_financier" class="form-control" min="0" step="1000" placeholder="Ex: 5000000" required>
        </div>

        <div class="form-row">
            <div class="form-group col-half">
                <label for="date_debut">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control">
            </div>
            <div class="form-group col-half">
                <label for="date_fin">Date de fin prévue</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg" style="margin-top: 20px;">
            Enregistrer et publier l'action
        </button>
    </form>
</div>
