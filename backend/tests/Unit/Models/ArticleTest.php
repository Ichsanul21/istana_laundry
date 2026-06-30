<?php

namespace Tests\Unit\Models;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_belongs_to_category(): void
    {
        $category = ArticleCategory::factory()->create();
        $article = Article::factory()->create(['category_id' => $category->id]);

        $this->assertEquals($category->id, $article->category->id);
    }

    public function test_published_scope_filters_by_status_and_date(): void
    {
        $published = Article::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $draft = Article::factory()->create([
            'status' => 'draft',
            'published_at' => null,
        ]);

        $scheduled = Article::factory()->create([
            'status' => 'scheduled',
            'published_at' => now()->addDay(),
        ]);

        $publishedArticles = Article::published()->get();

        $this->assertEquals(1, $publishedArticles->count());
        $this->assertEquals($published->id, $publishedArticles->first()->id);
    }

    public function test_draft_scope_filters_drafts(): void
    {
        Article::factory()->create(['status' => 'published']);
        Article::factory()->create(['status' => 'draft']);

        $drafts = Article::draft()->get();

        $this->assertEquals(1, $drafts->count());
        $this->assertEquals('draft', $drafts->first()->status);
    }

    public function test_recent_scope_orders_by_published_at(): void
    {
        $old = Article::factory()->create(['published_at' => now()->subDays(2)]);
        $new = Article::factory()->create(['published_at' => now()->subDay()]);

        $recent = Article::recent()->get();

        $this->assertEquals($new->id, $recent->first()->id);
        $this->assertEquals($old->id, $recent->last()->id);
    }

    public function test_slug_auto_generated_from_title(): void
    {
        $article = Article::factory()->create([
            'title' => 'Test Article Title',
            'slug' => null,
        ]);

        $this->assertEquals('test-article-title', $article->slug);
    }

    public function test_slug_not_overwritten_if_provided(): void
    {
        $article = Article::factory()->create([
            'title' => 'Test Article Title',
            'slug' => 'custom-slug',
        ]);

        $this->assertEquals('custom-slug', $article->slug);
    }

    public function test_article_soft_deletes(): void
    {
        $article = Article::factory()->create();
        $article->delete();

        $this->assertSoftDeleted($article);
        $this->assertNull(Article::find($article->id));
    }
}
