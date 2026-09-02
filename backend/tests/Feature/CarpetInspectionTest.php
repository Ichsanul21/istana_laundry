<?php

namespace Tests\Feature;

use App\Models\CarpetInspection;
use App\Services\CarpetInspectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use RuntimeException;
use Tests\TestCase;

class CarpetInspectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_returns_view(): void
    {
        $response = $this->get(route('karpet.index'));

        $response->assertStatus(200)
            ->assertViewIs('pages.karpet');
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->post(route('karpet.store'), []);

        $response->assertSessionHasErrors(['name', 'whatsapp', 'photo']);
    }

    public function test_store_rejects_non_image_upload(): void
    {
        $response = $this->post(route('karpet.store'), [
            'name' => 'Budi',
            'whatsapp' => '081234567890',
            'photo' => UploadedFile::fake()->create('karpet.txt', 100),
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_store_creates_completed_inspection_and_redirects(): void
    {
        $this->mock(CarpetInspectionService::class, function ($mock) {
            $mock->shouldReceive('storeOptimizedPhoto')->once()->andReturn('carpet-inspections/demo.jpg');
            $mock->shouldReceive('analyze')->once()->andReturn([
                'overall_condition' => 'Baik',
                'cleanliness_score' => 88,
                'findings' => [
                    ['label' => 'Debu', 'severity' => 'ringan', 'description' => 'Sedikit debu di permukaan.'],
                ],
                'recommendation' => 'Cukup lakukan pembersihan rutin.',
                'summary' => 'Karpet dalam kondisi bersih dan asri.',
            ]);
        });

        $response = $this->post(route('karpet.store'), [
            'name' => 'Budi',
            'whatsapp' => '0812-3456-7890',
            'notes' => 'Karpet ruang tamu',
            'photo' => UploadedFile::fake()->image('karpet.jpg'),
        ]);

        $inspection = CarpetInspection::first();

        $this->assertNotNull($inspection);
        $response->assertRedirect(route('karpet.show', $inspection->token));
        $this->assertEquals(CarpetInspectionService::STATUS_COMPLETED, $inspection->status);
        $this->assertEquals('081234567890', $inspection->whatsapp);
        $this->assertEquals('6281234567890', $inspection->wa_number);
        $this->assertEquals('Baik', $inspection->overall_condition);
        $this->assertEquals(88, $inspection->cleanliness_score);
        $this->assertCount(1, $inspection->findings);
    }

    public function test_store_marks_inspection_failed_when_ai_errors(): void
    {
        $this->mock(CarpetInspectionService::class, function ($mock) {
            $mock->shouldReceive('storeOptimizedPhoto')->once()->andReturn('carpet-inspections/demo.jpg');
            $mock->shouldReceive('analyze')->once()->andThrow(new RuntimeException('AI vision gagal'));
        });

        $response = $this->post(route('karpet.store'), [
            'name' => 'Budi',
            'whatsapp' => '081234567890',
            'notes' => null,
            'photo' => UploadedFile::fake()->image('karpet.jpg'),
        ]);

        $inspection = CarpetInspection::first();

        $this->assertNotNull($inspection);
        $response->assertRedirect(route('karpet.show', $inspection->token));
        $this->assertEquals(CarpetInspectionService::STATUS_FAILED, $inspection->status);
        $this->assertNotNull($inspection->error_message);
    }

    public function test_show_returns_result_view(): void
    {
        $inspection = CarpetInspection::factory()->create();

        $response = $this->get(route('karpet.show', $inspection->token));

        $response->assertStatus(200)
            ->assertViewIs('pages.karpet-result')
            ->assertViewHas('inspection');
    }

    public function test_show_resolves_by_token_not_id(): void
    {
        $inspection = CarpetInspection::factory()->create();
        CarpetInspection::factory()->create();

        $response = $this->get(route('karpet.show', $inspection->token));

        $response->assertOk();
        $this->assertEquals($inspection->id, $response->viewData('inspection')->id);
    }
}
