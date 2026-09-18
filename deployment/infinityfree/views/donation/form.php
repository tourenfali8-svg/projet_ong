<div class="page-header">
    <div class="container">
        <h1>Soutenez la mission de l'ONG AL HIKMAH</h1>
        <p>Chaque contribution aide l'ONG AL HIKMAH à poursuivre son accompagnement, sa guidance et ses actions de développement au service des personnes, des familles et des communautés.</p>
    </div>
</div>

<div class="container page-content">
    <div class="donation-form-wrapper">
        <form action="/don/traiter" method="POST" id="donation-form" class="card donation-main-card">
            <?= $csrfField ?>

            <!-- Étape 1 : Choix du type de don (Innovation 2 : Don intelligent & récurrent) -->
            <div class="donation-step">
                <label class="step-label">1. Choisissez votre mode de soutien</label>
                <div class="donation-type-switch">
                    <label class="switch-option active" id="option-ponctuel">
                        <input type="radio" name="type_don" value="ponctuel" checked>
                        <span>Don Ponctuel (Une fois)</span>
                    </label>
                    <label class="switch-option" id="option-recurrent">
                        <input type="radio" name="type_don" value="recurrent">
                        <span>Don Récurrent (Régulier)</span>
                    </label>
                </div>

                <div id="recurring-frequency-group" class="form-group hidden" style="margin-top: 15px;">
                    <label for="frequence">Fréquence du prélèvement :</label>
                    <select name="frequence" id="frequence" class="form-control">
                        <option value="mensuel" selected>Mensuel (Chaque mois)</option>
                        <option value="trimestriel">Trimestriel (Tous les 3 mois)</option>
                        <option value="annuel">Annuel (Chaque année)</option>
                    </select>
                </div>
            </div>

            <!-- Étape 2 : Montant du don -->
            <div class="donation-step">
                <label class="step-label">2. Définissez le montant de votre contribution (FCFA)</label>
                <div class="amount-presets-grid">
                    <?php foreach ($appConfig['donation_presets'] as $preset): ?>
                        <button type="button" class="preset-btn" data-amount="<?= $preset ?>">
                            <?= number_format($preset, 0, ',', ' ') ?> F
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="form-group" style="margin-top: 15px;">
                    <label for="montant">Ou saisissez un montant personnalisé :</label>
                    <div class="input-with-currency">
                        <input type="number" name="montant" id="montant" class="form-control form-control-lg" min="500" step="500" value="10000" required>
                        <span class="currency-tag">FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Étape 3 : Affectation du don (Innovation 2 : Choix précis de l'affectation) -->
            <div class="donation-step">
                <label class="step-label">3. Ciblez votre soutien</label>
                <div class="form-group">
                    <label for="action_id">Projet ou mission ciblée :</label>
                    <select name="action_id" id="action_id" class="form-control">
                        <option value="">Mission générale (Là où le besoin est le plus urgent)</option>
                        <?php foreach ($actions as $act): ?>
                            <option value="<?= $act['id'] ?>" <?= ($selectedAction && $selectedAction['id'] === $act['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($act['titre']) ?> (Collecté : <?= $act['pourcentage_collecte'] ?>%)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Étape 4 : Coordonnées du donateur -->
            <div class="donation-step">
                <label class="step-label">4. Renseignez vos coordonnées</label>
                <div class="form-row">
                    <div class="form-group col-half">
                        <label for="nom">Nom *</label>
                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Votre nom de famille" required>
                    </div>
                    <div class="form-group col-half">
                        <label for="prenom">Prénom *</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Votre prénom" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-half">
                        <label for="email">Adresse Email (pour recevoir votre justificatif)</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="exemple@email.com">
                    </div>
                </div>
                <div class="form-group">
                    <label for="message">Message de soutien (optionnel)</label>
                    <textarea name="message" id="message" class="form-control" rows="3" placeholder="Ex : Je souhaite soutenir cette initiative pour accompagner davantage de personnes."></textarea>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" name="anonyme" value="1">
                        Garder mon don anonyme sur les remerciements publics
                    </label>
                </div>
            </div>

            <!-- Étape 5 : Finalisation du don -->
            <div class="donation-step">
                <label class="step-label">5. Finalisation du soutien</label>
                <p style="margin-bottom: 0; color: #4a5568; line-height: 1.6;">
                    En cliquant sur le bouton ci-dessous, vous serez redirigé vers WhatsApp pour confirmer votre don et envoyer votre message de soutien directement à l’ONG AL HIKMAH.
                </p>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <a href="https://wa.me/<?= htmlspecialchars($appConfig['organization']['phone'] ?? '2250507674208') ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn btn-outline btn-block">
                    Ouvrir WhatsApp directement
                </a>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;">
                Continuer sur WhatsApp
            </button>
        </form>
    </div>
</div>

<script src="/assets/js/donation.js"></script>
