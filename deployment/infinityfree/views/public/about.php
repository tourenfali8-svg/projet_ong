<div class="page-header">
    <div class="container">
        <h1>À Propos de l'ONG AL HIKMAH</h1>
        <p>Découvrez notre mission, notre vision et les valeurs qui inspirent chaque action de l'ONG AL HIKMAH dans l'éducation, la transmission et l'accompagnement des jeunes.</p>
    </div>
</div>

<div class="container page-content">
    <div class="about-grid">
        <div class="about-text">
            <h2>Notre Mission</h2>
            <p><?= htmlspecialchars($appConfig['organization']['mission']) ?></p>

            <h2>Notre Vision</h2>
            <p><?= htmlspecialchars($appConfig['organization']['vision']) ?></p>

            <h2>Notre Historique</h2>
            <p><?= htmlspecialchars($appConfig['organization']['history']) ?></p>

            <h2>Nos 4 Objectifs Spécifiques</h2>
            <div class="pillars-grid">
                <div class="pillar-card">
                    <span class="pillar-icon">🧭</span>
                    <h4>Encadrement éthique, moral et spirituel</h4>
                    <p>Assurer l'encadrement éthique, moral et spirituel de la jeunesse à travers des cercles d'enseignement et d'éveil, notamment via l'approche de la Tarbiyyah.</p>
                </div>
                <div class="pillar-card">
                    <span class="pillar-icon">📜</span>
                    <h4>Patrimoine culturel & valeurs ancestrales</h4>
                    <p>Promouvoir le patrimoine culturel, le respect des aînés et la transmission des valeurs ancestrales comme le faisait nos ancetres sous l'Arbres à palabres et des rencontres intergénérationnelles.</p>
                </div>
                <div class="pillar-card">
                    <span class="pillar-icon">🌱</span>
                    <h4>Formations pratiques qualifiantes</h4>
                    <p>l'ONG Al HIKMAH avec l'accompagnement des structures de formations et d'encadrements dispense des formations pratiques qualifiantes aux Ateliers Créatifs, Activités Physiques Adaptées (APA), Ateliers Culturels pour renforcer les compétences des jeunes vulnérables.</p>
                </div>
                <div class="pillar-card">
                    <span class="pillar-icon">🤝</span>
                    <h4>Autonomie économique & insertion sociale</h4>
                    <p>Favoriser la création d'activités génératrices de revenus et doter les bénéficiaires en matériel et fonds d'amorçage pour garantir leur autonomie financière.</p>
                </div>
            </div>
        </div>

        <aside class="about-sidebar">
            <div class="card card-sidebar">
                <h3>Contact & Siège</h3>
                <p><strong>Adresse :</strong> <?= htmlspecialchars($appConfig['organization']['address']) ?></p>
                <p><strong>Téléphone :</strong> <?= htmlspecialchars($appConfig['organization']['phone']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($appConfig['organization']['email']) ?></p>

                <div class="social-links social-links-inline" aria-label="Réseaux sociaux">
                    <a href="https://youtube.com/@alhikmah-k2u?si=ODXF3dVDghn56alJ" target="_blank" rel="noopener noreferrer" class="social-link social-youtube" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M23.5 6.2c-.3-1.2-1.2-2.1-2.4-2.4C19.2 3.4 12 3.4 12 3.4s-7.2 0-9.1.4C1.7 4.1.8 5 .5 6.2.1 8.1.1 12 .1 12s0 3.9.4 5.8c.3 1.2 1.2 2.1 2.4 2.4 1.9.4 9.1.4 9.1.4s7.2 0 9.1-.4c1.2-.3 2.1-1.2 2.4-2.4.4-1.9.4-5.8.4-5.8s0-3.9-.4-5.8ZM9.9 15.5V8.5l6 3.5-6 3.5Z"/></svg>
                    </a>
                    <a href="#" class="social-link social-facebook" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M13.5 21v-8h2.7l.4-3h-3.1V7.4c0-.9.3-1.6 1.6-1.6h1.7V2.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.1H7v3h2.4v8h4.1Z"/></svg>
                    </a>
                    <a href="https://www.tiktok.com/@alhikmah9675" target="_blank" rel="noopener noreferrer" class="social-link social-tiktok" aria-label="TikTok">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M15.5 3c.3 1.6 1.5 2.9 3.2 3.4v2.3c-1.2-.1-2.3-.5-3.2-1.2v7.2c0 2.7-2.2 4.9-4.9 4.9S6.7 17.3 6.7 14.6 8.9 9.7 11.6 9.7c.4 0 .7.1 1.1.2v2.3c-.4-.1-.7-.2-1.1-.2-1.5 0-2.8 1.2-2.8 2.8s1.2 2.8 2.8 2.8 2.8-1.2 2.8-2.8V3h2.6Z"/></svg>
                    </a>
                    <a href="https://wa.me/2250507674208" target="_blank" rel="noopener noreferrer" class="social-link social-whatsapp" aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M19.1 4.9A9.6 9.6 0 0 0 12.1 2a9.7 9.7 0 0 0-8.4 14.7L2 22l5.4-1.4a9.7 9.7 0 0 0 4.7 1.4h.1a9.6 9.6 0 0 0 6.9-3.3A9.6 9.6 0 0 0 19.1 4.9ZM12.2 18.1h-.1a8 8 0 0 1-4.1-1.1l-.3-.2-3.2.8.9-3.1-.2-.3a8 8 0 1 1 7.1 4.9Zm4.4-6c-.2-.1-1.3-.6-1.5-.7-.2-.1-.4-.1-.5.1-.1.1-.5.7-.6.8-.1.1-.2.1-.4 0-.2-.1-.8-.3-1.6-.9-.6-.5-1-1.1-1.2-1.3-.1-.2 0-.4.1-.5l.2-.2c.1-.1.1-.2.2-.3.1-.1.1-.2.2-.4.1-.1.1-.3 0-.4-.1-.1-.5-1.3-.7-1.8-.2-.5-.4-.4-.5-.4h-.4c-.1 0-.3 0-.5.1-.2.1-.6.6-.9 1.1-.3.6-.7 1.3-.7 2.5s.7 2.9.8 3.1c.1.2 1.4 2.2 3.5 3.1 2.1.9 2.1.6 2.5.5.4-.1 1.3-.5 1.5-1 .2-.5.2-1 .1-1.1-.1-.1-.2-.1-.4-.2Z"/></svg>
                    </a>
                </div>
                <hr>

                <h3 style="margin-top: 15px; margin-bottom: 12px;">Envoyer un message</h3>
                <form action="/a-propos/contact" method="POST" class="contact-form">
                    <?= $csrfField ?>

                    <div class="form-group">
                        <label for="nom">Nom complet</label>
                        <input type="text" name="nom" id="nom" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="objet">Objet</label>
                        <input type="text" name="objet" id="objet" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Envoyer le message</button>
                </form>

                <hr>
                <a href="/don" class="btn btn-primary btn-block">Soutenir notre action</a>
                <a href="/benevolat" class="btn btn-outline btn-block" style="margin-top:10px;">Devenir bénévole</a>
            </div>
        </aside>
    </div>
</div>
