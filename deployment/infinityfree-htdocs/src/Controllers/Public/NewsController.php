<?php

namespace App\Controllers\Public;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\News;

/**
 * Contrôleur des Actualités et Publications
 */
class NewsController extends Controller
{
    public function index(Request $request): void
    {
        $newsModel = new News();
        $articles = $newsModel->getPublished(30);

        $this->render('public.news.index', [
            'title' => 'Actualités & Vie de l\'ONG',
            'articles' => $articles
        ]);
    }

    public function show(Request $request): void
    {
        $id = (int)$request->param('id');
        $newsModel = new News();
        $article = $newsModel->find($id);

        if (!$article || $article['statut'] !== 'publie') {
            Response::notFound("Cet article n'existe pas ou n'est plus accessible.");
        }

        $this->render('public.news.show', [
            'title' => $article['titre'] . ' — Actualités ONG',
            'article' => $article
        ]);
    }
}
