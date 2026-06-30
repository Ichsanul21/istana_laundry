# Setup Guide — Istana Laundry

## Prasyarat

- PHP 8.3+ (extensions: pdo_sqlite, mbstring, xml, curl, gd, fileinfo)
- Composer 2.x
- Node.js 20+ & npm
- SQLite3 (development) / MySQL 8+ (production)

## Instalasi Development

### 1. Setup Backend

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
```

### 2. Database (SQLite)

```bash
touch database/database.sqlite
```

Konfigurasi di `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=/full/path/backend/database/database.sqlite
```

### 3. Migrate & Seed

```bash
php artisan migrate --seed
```

### 4. Storage Link

```bash
php artisan storage:link
```

### 5. Build Breeze Assets

```bash
npm install
npm run build
```

### 6. Jalankan

```bash
php artisan serve
# → http://localhost:8000
```

### 7. Buat Admin User

Buka `http://localhost:8000/register` dan daftar, atau:

```bash
php artisan tinker
> \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@istanalaundry.com',
    'password' => bcrypt('password')
  ]);
```

## Setup Production (MySQL)

```bash
# .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=istanalaundry
DB_USERNAME=root
DB_PASSWORD=secret

APP_ENV=production
APP_DEBUG=false
```

```bash
php artisan migrate --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Struktur Database (13 Tabel)

```
users, branches, location_checks,
article_categories, articles,
galleries, gallery_images,
services, promotions,
testimonials, faqs,
seo_settings, settings
```
