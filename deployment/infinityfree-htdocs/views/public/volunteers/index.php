<div class="page-header">
    <div class="container">
        <h1>Espace Bénévolat & Engagement</h1>
        <p>Mettez vos compétences, votre temps et votre passion au service de nos projets sur le terrain.</p>
    </div>
</div>

<div class="container page-content">
    <div class="volunteers-layout">
        <!-- Missions ouvertes -->
        <div class="missions-section">
            <h2>Missions Ouvertes aux Bénévoles</h2>
            <?php if (empty($missions)): ?>
                <div class="alert alert-info">
                    Aucune mission spécifique n'est actuellement ouverte au recrutement, mais vous pouvez déposer une candidature spontanée ci-contre !
                </div>
            <?php else: ?>
                <div class="missions-list">
                    <?php foreach ($missions as $m): ?>
                        <div class="mission-card card">
                            <div class="mission-header">
                                <h3><?= htmlspecialchars($m['titre']) ?></h3>
                                <span class="badge-location">📍 <?= htmlspecialchars($m['lieu'] ?? 'Abidjan / Terrain') ?></span>
                            </div>
                            <p><?= nl2br(htmlspecialchars($m['description'] ?? '')) ?></p>
                            <div class="mission-dates">
                                📅 Période : Du <?= $m['date_debut'] ? date('d/m/Y', strtotime($m['date_debut'])) : 'Dès que possible' ?> 
                                au <?= $m['date_fin'] ? date('d/m/Y', strtotime($m['date_fin'])) : 'Indéterminée' ?>
                            </div>
                            <button class="btn btn-outline btn-sm select-mission-btn" data-mission-id="<?= $m['id'] ?>" data-mission-title="<?= htmlspecialchars($m['titre']) ?>">
                                Postuler à cette mission ↓
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulaire de candidature -->
        <div class="application-form-section">
            <div class="card">
                <h2>Rejoindre l'équipe terrain</h2>
                <p>Complétez ce formulaire pour postuler à une mission ou proposer vos compétences bénévoles.</p>

                <form action="/benevolat/postuler" method="POST" class="form-standard">
                    <?= $csrfField ?>

                    <div class="form-group">
                        <label for="mission_id">Mission ciblée *</label>
                        <select name="mission_id" id="mission_id" class="form-control" required>
                            <option value="">Sélectionnez une mission...</option>
                            <?php foreach ($missions as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['titre']) ?> (<?= htmlspecialchars($m['lieu'] ?? 'Terrain') ?>)</option>
                            <?php endforeach; ?>
                            <option value="">──────── Domaine de bénévolat ────────</option>
                            <option value="graphiste">Graphiste</option>
                            <option value="videaste">Vidéaste</option>
                            <option value="montage-3d">Montage 3D</option>
                            <option value="cadreur">Cadreur</option>
                            <option value="logistique">Logistique</option>
                        </select>
                    </div>

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

                    <div class="form-row">
                        <div class="form-group col-half">
                            <label for="email">Adresse Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="exemple@domaine.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <p style="margin-bottom: 10px; color: #4a5568;">Si la redirection automatique ne se lance pas, utilisez le bouton ci-dessous.</p>
                        <a href="https://wa.me/<?= htmlspecialchars($appConfig['organization']['phone'] ?? '2250507674208') ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn btn-outline btn-block">
                            Ouvrir WhatsApp
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        Envoyer ma candidature bénévole
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.select-mission-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const select = document.getElementById('mission_id');
        select.value = btn.dataset.missionId;
        select.scrollIntoView({ behavior: 'smooth' });
    });
});
</script>
