<?php

namespace App\Services;

class JsonLdService
{
    public static function localBusiness(array $data = []): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $data['name'] ?? 'Istana Laundry',
            'description' => $data['description'] ?? '',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $data['address'] ?? '',
                'addressLocality' => 'Samarinda',
                'addressRegion' => 'Kalimantan Timur',
                'addressCountry' => 'ID',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $data['lat'] ?? 0,
                'longitude' => $data['lng'] ?? 0,
            ],
            'telephone' => $data['phone'] ?? '',
            'openingHours' => $data['open_hours'] ?? '',
            'image' => $data['image'] ?? '',
            'url' => $data['url'] ?? config('app.url'),
        ];
    }

    public static function article(array $data = []): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? '',
            'author' => [
                '@type' => 'Person',
                'name' => $data['author'] ?? 'Admin',
            ],
            'datePublished' => $data['published_at'] ?? now()->toIso8601String(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Istana Laundry',
            ],
        ];
    }

    public static function faqPage(array $faqs = []): array
    {
        $entities = array_map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ], $faqs);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    public static function imageGallery(array $images = []): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'ImageGallery',
            'image' => array_map(fn ($img) => [
                '@type' => 'ImageObject',
                'url' => $img['url'] ?? '',
                'name' => $img['caption'] ?? '',
                'description' => $img['alt_text'] ?? '',
            ], $images),
        ];
    }
}
