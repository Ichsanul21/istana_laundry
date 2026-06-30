# SEO Features — Istana Laundry

## Fitur SEO yang Tersedia

### 1. Meta Tags Per Halaman
Setiap halaman (home, article detail, gallery, dll) memiliki:
- **Title tag** — diatur via SEO Settings admin
- **Meta description** — max 160 karakter
- **Canonical URL** — prevent duplicate content

### 2. Open Graph (OG)
Untuk sharing ke Facebook, WhatsApp, LinkedIn, Telegram:
- `og:title` — judul yang tampil saat di-share
- `og:description` — deskripsi
- `og:image` — thumbnail (1200x630px)
- `og:url` — URL kanonikal
- `og:type` — website / article
- `og:locale` — id_ID

### 3. Twitter Card
- `twitter:card` — summary_large_image
- `twitter:title`, `twitter:description`, `twitter:image`

### 4. JSON-LD Schema (Structured Data)
- **LocalBusiness** — otomatis dari data cabang (nama, alamat, telepon, jam operasional, koordinat)
- **Article** — untuk setiap artikel blog (judul, penulis, tanggal publish, featured image)
- **FAQPage** — dari data FAQ (Question + Answer pairs)
- **ImageGallery** — dari data galeri

### 5. Sitemap XML
URL: `http://localhost:8000/sitemap.xml`
- Otomatis generate semua halaman + artikel
- Priority + changefreq per halaman

### 6. robots.txt
URL: `http://localhost:8000/robots.txt`
- Bisa diedit via admin panel → Pengaturan

### 7. Breadcrumbs
- Breadcrumb navigation di admin panel
- JSON-LD BreadcrumbList di halaman publik

## Cara Setting SEO

### Via Admin Panel
1. Login ke `/admin`
2. Buka **SEO Settings**
3. Pilih halaman yang akan di-setting (home / article / gallery / contact)
4. Isi:
   - Meta Title (50-60 karakter)
   - Meta Description (150-160 karakter)
   - OG Title
   - OG Description
   - OG Image URL
   - Schema Type (LocalBusiness / WebSite / Article)
5. Klik **Simpan**

### Untuk Artikel
Saat membuat/mengedit artikel, isi panel SEO di bagian bawah form editor.
