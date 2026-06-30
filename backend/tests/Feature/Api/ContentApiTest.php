<?php

namespace Tests\Feature\Api;

use App\Models\Faq;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_services_returns_active_services(): void
    {
        $active = Service::factory()->create(['is_active' => true]);
        $inactive = Service::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/services');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'description', 'price', 'unit', 'icon'],
                ],
            ]);

        $data = $response->json('data');
        $this->assertEquals(1, count($data));
        $this->assertEquals($active->id, $data[0]['id']);
    }

    public function test_get_testimonials_returns_active_testimonials(): void
    {
        $active = Testimonial::factory()->create(['is_active' => true]);
        $inactive = Testimonial::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/testimonials');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'customer_name', 'customer_title', 'rating', 'body', 'avatar'],
                ],
            ]);

        $data = $response->json('data');
        $this->assertEquals(1, count($data));
    }

    public function test_get_faqs_returns_active_faqs(): void
    {
        $active = Faq::factory()->create(['is_active' => true]);
        $inactive = Faq::factory()->create(['is_active' => false]);

        $response = $this->getJson('/api/faqs');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'question', 'answer', 'category'],
                ],
            ]);

        $data = $response->json('data');
        $this->assertEquals(1, count($data));
    }

    public function test_get_galleries_returns_active_galleries_with_images(): void
    {
        $gallery = Gallery::factory()->create(['is_active' => true]);
        $image = GalleryImage::factory()->create(['gallery_id' => $gallery->id]);

        $response = $this->getJson('/api/galleries');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'title', 'slug', 'description',
                        'images' => [
                            '*' => ['id', 'image_path', 'caption', 'alt_text', 'sort_order'],
                        ],
                    ],
                ],
            ]);
    }

    public function test_get_promotions_returns_current_active_promotions(): void
    {
        $current = Promotion::factory()->create([
            'is_active' => true,
            'start_date' => now()->subDay(),
            'end_date' => now()->addDay(),
        ]);

        $expired = Promotion::factory()->create([
            'is_active' => true,
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDay(),
        ]);

        $response = $this->getJson('/api/promotions');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertEquals(1, count($data));
        $this->assertEquals($current->id, $data[0]['id']);
    }

    public function test_get_settings_returns_all_settings(): void
    {
        Setting::create(['key' => 'company_name', 'value' => 'Istana Laundry']);
        Setting::create(['key' => 'company_phone', 'value' => '0811-5599-199']);

        $response = $this->getJson('/api/settings');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'company_name' => 'Istana Laundry',
                    'company_phone' => '0811-5599-199',
                ],
            ]);
    }
}
