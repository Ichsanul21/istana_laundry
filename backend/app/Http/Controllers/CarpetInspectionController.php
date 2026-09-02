<?php

namespace App\Http\Controllers;

use App\Models\CarpetInspection;
use App\Services\CarpetInspectionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CarpetInspectionController extends Controller
{
    public function __construct(private readonly CarpetInspectionService $service) {}

    public function index(): View
    {
        return view('pages.karpet');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $photoPath = $this->service->storeOptimizedPhoto($request->file('photo'));

        $inspection = CarpetInspection::create([
            'name' => $validated['name'],
            'whatsapp' => preg_replace('/[^0-9]/', '', $validated['whatsapp']),
            'notes' => $validated['notes'] ?? null,
            'photo_path' => $photoPath,
            'token' => Str::random(32),
            'status' => 'processing',
        ]);

        try {
            $result = $this->service->analyze($photoPath);

            $inspection->update([
                'status' => CarpetInspectionService::STATUS_COMPLETED,
                'overall_condition' => $result['overall_condition'],
                'cleanliness_score' => $result['cleanliness_score'],
                'findings' => $result['findings'],
                'recommendation' => $result['recommendation'],
                'summary' => $result['summary'],
                'raw_response' => json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'error_message' => null,
            ]);
        } catch (\Throwable $e) {
            report($e);

            $inspection->update([
                'status' => CarpetInspectionService::STATUS_FAILED,
                'error_message' => 'Layanan analisa sedang sibuk. Silakan coba lagi atau hubungi kami via WhatsApp.',
            ]);
        }

        return redirect()->route('karpet.show', $inspection->token);
    }

    public function show(CarpetInspection $inspection): View
    {
        return view('pages.karpet-result', compact('inspection'));
    }
}
