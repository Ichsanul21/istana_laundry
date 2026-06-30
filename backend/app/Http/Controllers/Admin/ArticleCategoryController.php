<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::withCount('articles')->orderBy('name')->get();

        return view('admin.pages.article-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.article-categories.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:article_categories,slug',
        ]);

        ArticleCategory::create($validated);

        return redirect()->route('admin.article-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ArticleCategory $articleCategory)
    {
        return view('admin.pages.article-categories.form', ['category' => $articleCategory]);
    }

    public function update(Request $request, ArticleCategory $articleCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:article_categories,slug,' . $articleCategory->id,
        ]);

        $articleCategory->update($validated);

        return redirect()->route('admin.article-categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(ArticleCategory $articleCategory)
    {
        if ($articleCategory->articles()->count() > 0) {
            return redirect()->route('admin.article-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki artikel.');
        }

        $articleCategory->delete();

        return redirect()->route('admin.article-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
