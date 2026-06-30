<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $articles = Article::published()->get();
        $branches = Branch::active()->get();
        $services = Service::active()->get();

        $urls = collect();

        $urls->push([
            'loc' => url('/'),
            'lastmod' => now()->toW3cString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ]);

        foreach ($articles as $article) {
            $urls->push([
                'loc' => url('/artikel/' . $article->slug),
                'lastmod' => $article->updated_at->toW3cString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ]);
        }

        foreach ($services as $service) {
            $urls->push([
                'loc' => url('/layanan#' . $service->slug),
                'lastmod' => $service->updated_at->toW3cString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ]);
        }

        $staticPages = [
            ['loc' => url('/galeri'), 'priority' => '0.6'],
            ['loc' => url('/faq'), 'priority' => '0.6'],
            ['loc' => url('/cek-jangkauan'), 'priority' => '0.7'],
            ['loc' => url('/kontak'), 'priority' => '0.5'],
        ];

        foreach ($staticPages as $page) {
            $urls->push(array_merge($page, [
                'lastmod' => now()->toW3cString(),
                'changefreq' => 'monthly',
            ]));
        }

        return response()->view('seo.sitemap', ['urls' => $urls], 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /admin/*\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
