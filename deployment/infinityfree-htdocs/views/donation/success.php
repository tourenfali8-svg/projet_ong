<div class="page-header header-success">
    <div class="container text-center">
        <span class="badge-success-large">✔</span>
        <h1>Merci infiniment pour votre générosité !</h1>
        <p>Votre don a été confirmé avec succès auprès de l'opérateur <?= strtoupper(str_replace('_', ' ', $transaction['operateur_paiement'])) ?>.</p>
    </div>
</div>

<div class="container page-content">
    <div class="success-card card">
        <div class="success-summary">
            <h3>Détails du Don</h3>
            <div class="receipt-box">
                <div class="receipt-row">
                    <span>Référence de transaction :</span>
                    <strong><?= htmlspecialchars($transaction['reference_transaction']) ?></strong>
                </div>
                <div class="receipt-row">
                    <span>Montant réglé :</span>
                    <strong><?= number_format($don['montant'], 0, ',', ' ') ?> FCFA</strong>
                </div>
                <div class="receipt-row">
                    <span>Date :</span>
                    <strong><?= date('d/m/Y à H:i', strtotime($transaction['date_transaction'])) ?></strong>
                </div>
                <div class="receipt-row">
                    <span>Donateur :</span>
                    <strong><?= htmlspecialchars($donor['prenom'] . ' ' . $donor['nom']) ?></strong>
                </div>
                <div class="receipt-row">
                    <span>Affectation :</span>
                    <strong><?= htmlspecialchars($don['affectation'] ?? 'Mission générale') ?></strong>
                </div>
            </div>
        </div>

        <!-- Récompenses & Fidélisation (Innovation 6) -->
        <div class="loyalty-box" style="margin-top: 25px;">
            <h3>❤ Votre Impact & Fidélisation Solidaire</h3>
            <p>
                Vous avez accumulé <strong><?= (int)$donor['points_fidelite'] ?> points de solidarité</strong> ! 
                Votre statut actuel est : <span class="badge-tier tier-<?= strtolower($donor['niveau']['nom'] ?? 'bronze') ?>"><?= htmlspecialchars($donor['niveau']['nom'] ?? 'Bronze') ?></span>.
            </p>

            <?php if (!empty($donor['badges'])): ?>
                <h4>Vos Badges Débloqués :</h4>
                <div class="badges-row">
                    <?php foreach ($donor['badges'] as $b): ?>
                        <div class="badge-chip">
                            🏅 <strong><?= htmlspecialchars($b['nom']) ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="success-actions" style="margin-top: 30px; display: flex; gap: 15px; justify-content: center;">
            <a href="/actions" class="btn btn-outline">
                Découvrir nos autres projets
            </a>
        </div>
    </div>
</div>
