<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_articles_returns_published_articles(): void
    {
        $published = Article::factory()->published()->create();
        $draft = Article::factory()->draft()->create();

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'title', 'slug', 'excerpt', 'featured_image',
                        'alt_text', 'author', 'published_at', 'category_id',
                    ],
                ],
            ]);

        $data = $response->json('data');
        $this->assertEquals(1, count($data));
        $this->assertEquals($published->id, $data[0]['id']);
    }

    public function test_get_articles_ordered_by_published_at_desc(): void
    {
        $old = Article::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);
        $new = Article::factory()->create([
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertCount(2, $data);
        $this->assertEquals($new->id, $data[0]['id']);
        $this->assertEquals($old->id, $data[1]['id']);
    }

    public function test_get_article_by_slug(): void
    {
        $article = Article::factory()->published()->create([
            'slug' => 'test-article',
        ]);

        $response = $this->getJson('/api/articles/test-article');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $article->id,
                    'slug' => 'test-article',
                ],
            ])
            ->assertJsonStructure([
                'data' => [
                    'id', 'title', 'slug', 'body', 'excerpt',
                    'featured_image', 'author', 'published_at',
                    'category',
                ],
            ]);
    }

    public function test_get_article_by_slug_returns_404_for_nonexistent(): void
    {
        $response = $this->getJson('/api/articles/nonexistent-slug');

        $response->assertStatus(404);
    }

    public function test_get_article_by_slug_returns_404_for_draft(): void
    {
        $draft = Article::factory()->draft()->create([
            'slug' => 'draft-article',
        ]);

        $response = $this->getJson('/api/articles/draft-article');

        $response->assertStatus(404);
    }
}
