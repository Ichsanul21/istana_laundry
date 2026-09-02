<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class CarpetInspectionService
{
    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';

    public function storeOptimizedPhoto(UploadedFile $file): string
    {
        $name = Str::random(24);
        $dir = storage_path('app/public/carpet-inspections');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $relative = 'carpet-inspections/'.$name.'.jpg';
        $target = storage_path('app/public/'.$relative);

        $source = $file->getRealPath();
        $ok = $this->downscaleJpeg($source, $target);

        if ($ok) {
            return $relative;
        }

        // Fallback: simpan file asli apa adanya.
        return $file->storeAs('carpet-inspections', $name.'.'.$file->getClientOriginalExtension(), 'public');
    }

    public function analyze(string $relativePath): array
    {
        $absolutePath = storage_path('app/public/'.$relativePath);

        if (! file_exists($absolutePath)) {
            throw new RuntimeException('Foto karpet tidak ditemukan.');
        }

        $provider = config('services.ai.provider', 'gemini');

        $result = match ($provider) {
            'cloudflare' => $this->analyzeWithCloudflare($absolutePath),
            default => $this->analyzeWithGemini($absolutePath),
        };

        return $this->normalize($result);
    }

    protected function analyzeWithGemini(string $absolutePath): array
    {
        $apiKey = config('services.gemini.api_key');
        if (blank($apiKey)) {
            throw new RuntimeException('API key Gemini belum dikonfigurasi.');
        }

        $model = config('services.gemini.model', 'gemini-2.5-flash');
        $baseUrl = config('services.gemini.base_url');
        $mime = mime_content_type($absolutePath) ?: 'image/jpeg';
        $imageBase64 = base64_encode((string) file_get_contents($absolutePath));

        $response = Http::connectTimeout(10)
            ->timeout(90)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $apiKey,
            ])
            ->post("{$baseUrl}/models/{$model}:generateContent", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $this->buildPrompt()],
                            ['inline_data' => [
                                'mime_type' => $mime,
                                'data' => $imageBase64,
                            ]],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'response_mime_type' => 'application/json',
                    'temperature' => 0.2,
                    'max_output_tokens' => 1200,
                ],
            ]);

        if ($response->failed()) {
            throw new RuntimeException('AI vision gagal: '.$response->body());
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

        return $this->extractJson((string) $text);
    }

    protected function analyzeWithCloudflare(string $absolutePath): array
    {
        $accountId = config('services.cloudflare.account_id');
        $apiToken = config('services.cloudflare.api_token');
        if (blank($accountId) || blank($apiToken)) {
            throw new RuntimeException('Kredensial Cloudflare AI belum dikonfigurasi.');
        }

        $model = config('services.cloudflare.model');
        $imageBase64 = 'data:image/jpeg;base64,'.base64_encode((string) file_get_contents($absolutePath));

        $response = Http::connectTimeout(10)
            ->timeout(90)
            ->withToken($apiToken)
            ->post("https://api.cloudflare.com/client/v4/accounts/{$accountId}/ai/run/{$model}", [
                'messages' => [
                    ['role' => 'system', 'content' => $this->buildPrompt()],
                    ['role' => 'user', 'content' => 'Analisa foto karpet ini.'],
                ],
                'image' => $imageBase64,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('AI vision gagal: '.$response->body());
        }

        return $this->extractJson((string) data_get($response->json(), 'result.response'));
    }

    protected function buildPrompt(): string
    {
        return <<<'PROMPT'
Anda adalah asisten ahli perawatan karpet dari "Istana Laundry Samarinda".
Analisa foto karpet yang dikirim pelanggan dan buat diagnosa kondisi karpet.

Perhatikan hal-hal berikut bila terlihat:
- Noda (tumpahan, kotoran, noda membandel)
- Jamur / bercak lembap (moisture stain)
- Keausan serat / kusam / kering
- Sobek, tepi mengelupas, atau kerusakan fisik
- Bulu hewan, tungau, atau tanda bau
- Kondisi keseluruhan karpet

Balas HANYA dengan satu objek JSON valid (tanpa markdown, tanpa teks lain), dengan skema:
{
  "overall_condition": "Baik" | "Sedang" | "Buruk",
  "cleanliness_score": <angka 0-100>,
  "findings": [
    { "label": "Nama temuan", "severity": "ringan" | "sedang" | "parah", "description": "Penjelasan singkat" }
  ],
  "recommendation": "Rekomendasi penanganan dari Istana Laundry",
  "summary": "Ringkasan 1-2 kalimat kondisi karpet"
}

Jika foto tidak menunjukkan karpet atau kualitas foto kurang jelas, tetap jawab dengan struktur yang sama dan jelaskan di summary.
Jika tidak ada temuan berarti, returns finding kosong [].
PROMPT;
    }

    protected function extractJson(string $text): array
    {
        $trimmed = trim($text);
        if (Str::startsWith($trimmed, '```')) {
            $trimmed = preg_replace('/^```(?:json)?\s*/i', '', $trimmed);
            $trimmed = preg_replace('/\s*```$/', '', $trimmed);
        }

        $start = strpos($trimmed, '{');
        $end = strrpos($trimmed, '}');
        if ($start === false || $end === false || $end <= $start) {
            throw new RuntimeException('Respons AI tidak mengandung JSON yang valid.');
        }

        $decoded = json_decode(substr($trimmed, $start, $end - $start + 1), true);
        if (! is_array($decoded)) {
            throw new RuntimeException('Respons AI tidak dapat di-parse sebagai JSON.');
        }

        return $decoded;
    }

    protected function normalize(array $result): array
    {
        $findings = collect(data_get($result, 'findings', []))
            ->filter(fn ($f) => is_array($f))
            ->map(fn ($f) => [
                'label' => (string) data_get($f, 'label', 'Temuan'),
                'severity' => in_array(data_get($f, 'severity'), ['ringan', 'sedang', 'parah'], true)
                    ? data_get($f, 'severity')
                    : 'sedang',
                'description' => (string) data_get($f, 'description', ''),
            ])
            ->values()
            ->all();

        $score = (int) data_get($result, 'cleanliness_score', 50);
        $score = max(0, min(100, $score));

        return [
            'overall_condition' => in_array(data_get($result, 'overall_condition'), ['Baik', 'Sedang', 'Buruk'], true)
                ? data_get($result, 'overall_condition')
                : 'Sedang',
            'cleanliness_score' => $score,
            'findings' => $findings,
            'recommendation' => (string) data_get($result, 'recommendation', ''),
            'summary' => (string) data_get($result, 'summary', ''),
        ];
    }

    protected function downscaleJpeg(string $source, string $target, ?int $maxDimension = null, ?int $quality = null): bool
    {
        if (! function_exists('imagecreatefromstring')) {
            return false;
        }

        $maxDimension ??= (int) config('services.ai.max_image_dimension', 1600);
        $quality ??= (int) config('services.ai.image_quality', 82);

        $data = @file_get_contents($source);
        $src = @imagecreatefromstring((string) $data);
        if ($src === false) {
            return false;
        }

        $width = (int) imagesx($src);
        $height = (int) imagesy($src);
        $scale = min(1, $maxDimension / max(1, max($width, $height)));
        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $ok = imagejpeg($dst, $target, $quality);

        imagedestroy($src);
        imagedestroy($dst);

        return $ok;
    }
}
