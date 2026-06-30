<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('category')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(15)->withQueryString();

        return view('admin.pages.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = ArticleCategory::orderBy('name')->get();

        return view('admin.pages.articles.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'body' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:article_categories,id',
            'author' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'og_title' => 'nullable|string|max:70',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $validated['author'] = $validated['author'] ?? auth()->user()->name;

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::orderBy('name')->get();

        return view('admin.pages.articles.form', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'body' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:article_categories,id',
            'author' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'og_title' => 'nullable|string|max:70',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
