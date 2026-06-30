<?php

namespace App\Http\Middleware;

use App\Models\SeoSetting;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$response->isSuccessful() || $request->is('admin/*') || $request->is('admin') || $request->is('api/*')) {
            return $response;
        }

        try {
            $page = $this->resolvePage($request);
            $seo = SeoSetting::forPage($page)->first();

            $metaTitle = $seo?->meta_title ?? Setting::getValue('default_meta_title', config('app.name'));
            $metaDescription = $seo?->meta_description ?? Setting::getValue('default_meta_description', '');
            $ogTitle = $seo?->og_title ?? $metaTitle;
            $ogDescription = $seo?->og_description ?? $metaDescription;
            $ogImage = $seo?->og_image;

            $response->headers->set('X-SEO-Page', $page);

            view()->share('seo', [
                'title' => $metaTitle,
                'description' => $metaDescription,
                'og_title' => $ogTitle,
                'og_description' => $ogDescription,
                'og_image' => $ogImage,
                'schema_type' => $seo?->schema_type,
            ]);
        } catch (\Throwable) {
            // Silently fail if database is not available
        }

        return $response;
    }

    private function resolvePage(Request $request): string
    {
        $path = trim($request->path(), '/');

        return match (true) {
            $path === '' || $path === '/' => 'home',
            str_starts_with($path, 'artikel/') => 'article',
            str_starts_with($path, 'galeri') => 'gallery',
            str_starts_with($path, 'layanan') => 'service',
            str_starts_with($path, 'promo') => 'promotion',
            str_starts_with($path, 'faq') => 'faq',
            str_starts_with($path, 'cek-jangkauan') => 'location-check',
            default => $path ?: 'home',
        };
    }
}
