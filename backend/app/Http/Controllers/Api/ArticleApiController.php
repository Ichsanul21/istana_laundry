<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleApiController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->recent()
            ->with('category')
            ->get([
                'id', 'title', 'slug', 'excerpt', 'featured_image', 'alt_text',
                'author', 'published_at', 'category_id',
            ]);

        return response()->json(['data' => $articles]);
    }

    public function show(string $slug)
    {
        $article = Article::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json(['data' => $article]);
    }
}
