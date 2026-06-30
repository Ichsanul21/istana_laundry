<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_article_index_requires_authentication(): void
    {
        $response = $this->get(route('admin.articles.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_article_index_returns_view(): void
    {
        Article::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.articles.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.articles.index')
            ->assertViewHas('articles');
    }

    public function test_article_index_filters_by_status(): void
    {
        Article::factory()->published()->create();
        Article::factory()->draft()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.articles.index', ['status' => 'published']));

        $response->assertStatus(200);
        $articles = $response->viewData('articles');
        $this->assertEquals(1, $articles->count());
    }

    public function test_article_create_returns_view(): void
    {
        ArticleCategory::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.articles.create'));

        $response->assertStatus(200)
            ->assertViewIs('admin.pages.articles.form')
            ->assertViewHas('categories');
    }

    public function test_article_store_validates_data(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.articles.store'), []);

        $response->assertSessionHasErrors(['title', 'body', 'status']);
    }

    public function test_article_store_creates_article(): void
    {
        $category = ArticleCategory::factory()->create();

        $data = [
            'title' => 'Test Article',
            'body' => 'This is the article body content.',
            'excerpt' => 'Short excerpt',
            'category_id' => $category->id,
            'status' => 'draft',
            'author' => 'Test Author',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.articles.store'), $data);

        $response->assertRedirect(route('admin.articles.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
            'status' => 'draft',
        ]);
    }

    public function test_article_store_sets_published_at_when_published(): void
    {
        $data = [
            'title' => 'Published Article',
            'body' => 'Content here',
            'status' => 'published',
        ];

        $this->actingAs($this->admin)
            ->post(route('admin.articles.store'), $data);

        $this->assertDatabaseHas('articles', [
            'title' => 'Published Article',
            'status' => 'published',
        ]);

        $article = Article::where('title', 'Published Article')->first();
        $this->assertNotNull($article->published_at);
    }

    public function test_article_update_updates_article(): void
    {
        $article = Article::factory()->create();

        $data = [
            'title' => 'Updated Title',
            'body' => 'Updated body content',
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('admin.articles.update', $article), $data);

        $response->assertRedirect(route('admin.articles.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_article_destroy_soft_deletes_article(): void
    {
        $article = Article::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.articles.destroy', $article));

        $response->assertRedirect(route('admin.articles.index'))
            ->assertSessionHas('success');

        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }
}
