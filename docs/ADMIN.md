# Admin Panel Guide — Istana Laundry

URL: `http://localhost:8000/admin`

Login menggunakan akun yang didaftarkan via `/register`.

## Sidebar Navigation

```
📊 MENU
   └─ Dashboard
📌 CABANG
   ├─ Semua Cabang
   └─ Tambah Cabang
📄 KONTEN
   ├─ Artikel
   ├─ Kategori Artikel
   └─ Galeri
💰 LAYANAN
   ├─ Layanan & Harga
   └─ Promo
💬 INTERAKSI
   ├─ Testimoni
   ├─ FAQ
   └─ Pengecekan Lokasi
⚙️ PENGATURAN
   ├─ SEO Settings
   └─ Pengaturan Umum
```

## Fitur per Halaman

### 🏠 Dashboard
- Total cabang, artikel, galeri, pengecekan hari ini
- Grafik pengecekan per minggu

### 📌 Cabang
- **Index**: Tabel semua cabang (nama, tipe, alamat, status)
- **Create/Edit**: Form lengkap + **Leaflet Map Picker**
  - Klik map → isi lat/lng otomatis
  - Marker bisa di-drag
  - Radius bisa diatur per cabang (km)
- **Show**: Detail cabang + daftar pengecekan terdekat

### 📄 Artikel
- **Index**: Tabel dengan filter status (draft/published/scheduled)
- **Create/Edit**:
  - Editor WYSIWYG (Summernote)
  - SEO Panel: meta title, meta desc, OG title, OG desc, OG image
  - Featured image upload + alt text
  - Kategori + slug (auto dari judul, bisa diedit)
- **Show**: Preview artikel + JSON-LD schema

### 🖼️ Galeri
- **Index**: Grid thumbnail galeri
- **Create/Edit**:
  - Dropzone drag & drop upload multiple images
  - Reorder images via drag
  - Caption + alt text per image

### 💰 Layanan & Harga
- **Index**: Tabel layanan (nama, harga, unit, status)
- **Create/Edit**: Nama, deskripsi, harga, unit (kg/pcs), icon (iconify picker)

### 🎯 Promo
- **Index**: Tabel promo (judul, diskon, periode)
- **Create/Edit**: Judul, deskripsi, gambar, tipe diskon (percent/fixed), nilai, tanggal mulai & akhir

### 💬 Testimoni
- **Index**: Tabel (nama, rating, status)
- **Create/Edit**: Nama, jabatan, rating (1-5 bintang), body, avatar

### ❓ FAQ
- **Index**: Tabel (pertanyaan, kategori, urutan)
- **Create/Edit**: Pertanyaan, jawaban, kategori, urutan

### 📊 Pengecekan Lokasi
- **Index**: Tabel filterable (tanggal, cabang, status radius)
- **Show**: Detail + map hasil pengecekan
- **Export**: CSV

### 🌐 SEO Settings
- Form per halaman (home, article, gallery, contact, etc.)
- Meta title, meta description, OG fields, schema type

### ⚙️ Pengaturan Umum
- WhatsApp number (default admin)
- Default radius (km)
- Site name
- Logo
