<div class="page-header">
    <div class="container">
        <h1>Actualités & Messages de Guidance</h1>
        <p>Suivez les dernières nouvelles, initiatives et messages inspirants de l'ONG AL HIKMAH pour accompagner les personnes dans leur chemin.</p>
    </div>
</div>

<div class="container page-content">
    <div class="cards-grid">
        <?php if (empty($articles)): ?>
            <div class="alert alert-info">Aucun article publié pour le moment.</div>
        <?php else: ?>
            <?php foreach ($articles as $art): ?>
                <div class="news-card card">
                    <div class="news-date">
                        📅 <?= date('d/m/Y', strtotime($art['date_publication'] ?? $art['date_creation'])) ?>
                        <?php if (!empty($art['action_titre'])): ?>
                            • 🎯 <em><?= htmlspecialchars($art['action_titre']) ?></em>
                        <?php endif; ?>
                    </div>
                    <h2><a href="/actualites/<?= $art['id'] ?>"><?= htmlspecialchars($art['titre']) ?></a></h2>
                    <p><?= htmlspecialchars(mb_substr(strip_tags($art['contenu']), 0, 150)) ?>...</p>
                    <a href="/actualites/<?= $art['id'] ?>" class="read-more">Lire l'article complet →</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
