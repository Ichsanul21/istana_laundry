<?php

namespace Tests\Feature\Admin;

use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Promotion;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentControllersTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_service_crud(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.services.index'));
        $response->assertStatus(200);

        $data = [
            'name' => 'Test Service',
            'description' => 'Test description',
            'price' => 15000,
            'unit' => 'kg',
            'is_active' => true,
            'sort_order' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), $data);
        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['name' => 'Test Service']);

        $service = Service::where('name', 'Test Service')->first();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.services.update', $service), array_merge($data, ['name' => 'Updated Service']));
        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['id' => $service->id, 'name' => 'Updated Service']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.services.destroy', $service));
        $response->assertRedirect(route('admin.services.index'));
        $this->assertSoftDeleted('services', ['id' => $service->id]);
    }

    public function test_promotion_crud(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.promotions.index'));
        $response->assertStatus(200);

        $data = [
            'title' => 'Test Promo',
            'description' => 'Test description',
            'discount_type' => 'percent',
            'discount_value' => 20,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(30)->format('Y-m-d'),
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.promotions.store'), $data);
        $response->assertRedirect(route('admin.promotions.index'));
        $this->assertDatabaseHas('promotions', ['title' => 'Test Promo']);

        $promo = Promotion::where('title', 'Test Promo')->first();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.promotions.update', $promo), array_merge($data, ['title' => 'Updated Promo']));
        $response->assertRedirect(route('admin.promotions.index'));
        $this->assertDatabaseHas('promotions', ['id' => $promo->id, 'title' => 'Updated Promo']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.promotions.destroy', $promo));
        $response->assertRedirect(route('admin.promotions.index'));
        $this->assertSoftDeleted('promotions', ['id' => $promo->id]);
    }

    public function test_testimonial_crud(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.testimonials.index'));
        $response->assertStatus(200);

        $data = [
            'customer_name' => 'Test Customer',
            'customer_title' => 'Test Title',
            'rating' => 5,
            'body' => 'Great service!',
            'is_active' => true,
            'sort_order' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.testimonials.store'), $data);
        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', ['customer_name' => 'Test Customer']);

        $testimonial = Testimonial::where('customer_name', 'Test Customer')->first();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.testimonials.update', $testimonial), array_merge($data, ['customer_name' => 'Updated Customer']));
        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', ['id' => $testimonial->id, 'customer_name' => 'Updated Customer']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.testimonials.destroy', $testimonial));
        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_faq_crud(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.faqs.index'));
        $response->assertStatus(200);

        $data = [
            'question' => 'Test Question?',
            'answer' => 'Test answer here.',
            'category' => 'Layanan',
            'is_active' => true,
            'sort_order' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.faqs.store'), $data);
        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseHas('faqs', ['question' => 'Test Question?']);

        $faq = Faq::where('question', 'Test Question?')->first();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.faqs.update', $faq), array_merge($data, ['question' => 'Updated Question?']));
        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseHas('faqs', ['id' => $faq->id, 'question' => 'Updated Question?']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.faqs.destroy', $faq));
        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    public function test_gallery_crud(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.galleries.index'));
        $response->assertStatus(200);

        $data = [
            'title' => 'Test Gallery',
            'description' => 'Test description',
            'is_active' => true,
            'sort_order' => 1,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.galleries.store'), $data);
        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', ['title' => 'Test Gallery']);

        $gallery = Gallery::where('title', 'Test Gallery')->first();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.galleries.update', $gallery), array_merge($data, ['title' => 'Updated Gallery']));
        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertDatabaseHas('galleries', ['id' => $gallery->id, 'title' => 'Updated Gallery']);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.galleries.destroy', $gallery));
        $response->assertRedirect(route('admin.galleries.index'));
        $this->assertSoftDeleted('galleries', ['id' => $gallery->id]);
    }
}
