<div class="page-header">
    <div class="container">
        <div class="news-date" style="color: rgba(255,255,255,0.85); margin-bottom: 10px;">
            📅 Publié le <?= date('d/m/Y à H:i', strtotime($article['date_publication'] ?? $article['date_creation'])) ?>
        </div>
        <h1><?= htmlspecialchars($article['titre']) ?></h1>
    </div>
</div>

<div class="container page-content">
    <div class="article-layout">
        <article class="article-content card">
            <div class="article-body">
                <?= nl2br(htmlspecialchars($article['contenu'])) ?>
            </div>
            
            <hr style="margin: 30px 0;">
            <div class="article-footer-nav">
                <a href="/actualites" class="btn btn-outline">← Retour aux actualités</a>
                <a href="/don" class="btn btn-primary">Soutenir nos actions</a>
            </div>
        </article>
    </div>
</div>
