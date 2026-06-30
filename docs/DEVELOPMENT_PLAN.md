# Development Plan — Istana Laundry

Eksekusi dibagi dalam 7 batch, dijalankan berurutan.

---

## Batch 1: Laravel Init + Breeze + Tailwind + Admin Layout

| # | Step | Est. |
|:-:|------|:----:|
| 1.1 | `composer create-project laravel/laravel backend` | 2 menit |
| 1.2 | Install Breeze (Blade + Alpine) + `npm install && npm run build` | 3 menit |
| 1.3 | Config `.env` SQLite, `key:generate` | 1 menit |
| 1.4 | Tailwind config: custom colors (orange brand), font Outfit, shadows | 3 menit |
| 1.5 | Admin layout: `layouts/admin.blade.php` — sidebar TailAdmin-style + header + content | 10 menit |
| 1.6 | Sidebar component + Header component (search, notif, user dropdown) | 10 menit |
| 1.7 | UI components: card, button, badge, breadcrumb, modal, pagination, alert | 15 menit |
| 1.8 | Form components: input, select, textarea, checkbox, radio, label | 10 menit |

**Total: ~54 menit**

---

## Batch 2: Database (13 Migrations + Models + Seeders)

| # | Step | Est. |
|:-:|------|:----:|
| 2.1 | Migration: `branches` + `location_checks` | 5 menit |
| 2.2 | Migration: `article_categories` + `articles` | 5 menit |
| 2.3 | Migration: `galleries` + `gallery_images` | 3 menit |
| 2.4 | Migration: `services` + `promotions` | 3 menit |
| 2.5 | Migration: `testimonials` + `faqs` | 3 menit |
| 2.6 | Migration: `seo_settings` + `settings` | 3 menit |
| 2.7 | All 13 Models (fillable, casts, relationships, scopes) | 15 menit |
| 2.8 | Haversine scope on Branch + HaversineService | 5 menit |
| 2.9 | BranchSeeder (6 cabang) | 3 menit |
| 2.10 | Sample seeders: articles, services, testimonials, FAQs, galleries, promotions | 10 menit |

**Total: ~55 menit**

---

## Batch 3: Admin CRUD — Core (Dashboard + Cabang + Pengecekan)

| # | Step | Est. |
|:-:|------|:----:|
| 3.1 | DashboardController + view (stats cards) | 10 menit |
| 3.2 | BranchController: index + Blade table | 10 menit |
| 3.3 | BranchController: create + form with Leaflet map picker | 15 menit |
| 3.4 | BranchController: edit + show + delete | 10 menit |
| 3.5 | LocationCheckController: index (filterable) + show (detail map) | 15 menit |
| 3.6 | Export CSV location checks | 5 menit |

**Total: ~65 menit**

---

## Batch 4: Admin CRUD — Content (Artikel + Galeri + Layanan + Promo)

| # | Step | Est. |
|:-:|------|:----:|
| 4.1 | ArticleController: index + filter status | 10 menit |
| 4.2 | ArticleController: create/edit with Summernote + SEO panel | 20 menit |
| 4.3 | ArticleCategoryController | 5 menit |
| 4.4 | GalleryController: index + create with Dropzone upload | 15 menit |
| 4.5 | GalleryController: edit (reorder images) + delete | 10 menit |
| 4.6 | ServiceController: CRUD | 10 menit |
| 4.7 | PromotionController: CRUD | 10 menit |

**Total: ~80 menit**

---

## Batch 5: Admin CRUD — Interaksi + Settings (Testimoni + FAQ + SEO + Pengaturan)

| # | Step | Est. |
|:-:|------|:----:|
| 5.1 | TestimonialController: CRUD | 10 menit |
| 5.2 | FaqController: CRUD | 10 menit |
| 5.3 | SeoSettingController: form per halaman | 10 menit |
| 5.4 | SettingController: general settings form | 10 menit |

**Total: ~40 menit**

---

## Batch 6: Public API + SEO Engine + Sitemap

| # | Step | Est. |
|:-:|------|:----:|
| 6.1 | BranchController API: GET /api/branches | 5 menit |
| 6.2 | LocationCheckController API: POST /api/location/check (Haversine) | 10 menit |
| 6.3 | ArticleController API: GET /api/articles + GET /api/articles/{slug} | 10 menit |
| 6.4 | Gallery API, Service API, Promotion API, Testimonial API, Faq API, Settings API | 20 menit |
| 6.5 | SEO middleware — inject meta/OG/schema from seo_settings | 10 menit |
| 6.6 | JSON-LD helpers (LocalBusiness, Article, FAQPage, ImageGallery) | 10 menit |
| 6.7 | Sitemap controller + XML view | 5 menit |
| 6.8 | robots.txt route | 3 menit |

**Total: ~73 menit**

---

## Batch 7: Frontend (index.html Update)

| # | Section | Est. |
|:-:|---------|:----:|
| 7.1 | "Cek Jangkauan" — Leaflet map + branch markers + radius circles | 20 menit |
| 7.2 | Form cek: Nama, WA, Alamat + pin drop on map click | 10 menit |
| 7.3 | Hasil cek: AJAX POST + tampil ✅/❌ + WA CTA button | 10 menit |
| 7.4 | Services section → dinamis dari API (fallback static) | 10 menit |
| 7.5 | Testimonials section → dinamis dari API (fallback static) | 5 menit |
| 7.6 | FAQ section → accordion baru dari API | 10 menit |
| 7.7 | Gallery section → grid baru dari API | 10 menit |
| 7.8 | Article/Blog section → 3 artikel terbaru dari API | 10 menit |
| 7.9 | Promo banner → dari API | 5 menit |

**Total: ~90 menit**

---

## Ringkasan

| Batch | Isi | Estimasi |
|:-----:|-----|:--------:|
| 1 | Laravel init + Breeze + Admin layout + UI components | ~54 menit |
| 2 | 13 migrations + models + seeders | ~55 menit |
| 3 | Admin: Dashboard + Cabang + Pengecekan | ~65 menit |
| 4 | Admin: Artikel + Galeri + Layanan + Promo | ~80 menit |
| 5 | Admin: Testimoni + FAQ + SEO + Settings | ~40 menit |
| 6 | Public API + SEO Engine + Sitemap | ~73 menit |
| 7 | Frontend index.html update (7 sections) | ~90 menit |
| **Total** | | **~6.5 jam** |
