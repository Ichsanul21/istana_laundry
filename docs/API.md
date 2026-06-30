# API Documentation — Istana Laundry

Base URL: `http://localhost:8000/api`

Semua response dalam format JSON.

## Branches

### GET /api/branches

Daftar cabang aktif.

**Response:**
```json
[
  {
    "id": 1,
    "name": "Workshop Utama",
    "type": "workshop",
    "address": "Jl. Wijaya Kusuma V-C, Gg. Rina, Air Hitam, Samarinda Ulu",
    "lat": -0.4869703,
    "lng": 117.1292781,
    "radius_km": 3,
    "phone": "0811-5599-199",
    "is_active": true
  }
]
```

## Location Check

### POST /api/location/check

Cek apakah alamat pelanggan dalam radius jangkauan.

**Request:**
```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "whatsapp": "6281234567890",
  "address": "Jl. Contoh No. 123, Samarinda",
  "lat": -0.485,
  "lng": 117.130
}
```

**Response:**
```json
{
  "is_within_radius": true,
  "nearest_branch": {
    "id": 1,
    "name": "Workshop Utama",
    "distance_km": 0.523
  },
  "branches_in_range": [
    {
      "id": 1,
      "name": "Workshop Utama",
      "distance_km": 0.523
    }
  ]
}
```

## Articles

| Endpoint | Description |
|----------|-------------|
| `GET /api/articles` | Artikel published (pagination) |
| `GET /api/articles/{slug}` | Detail artikel + JSON-LD |

## Galleries

| Endpoint | Description |
|----------|-------------|
| `GET /api/galleries` | Galeri dengan images |

## Services

| Endpoint | Description |
|----------|-------------|
| `GET /api/services` | Layanan aktif |

## Promotions

| Endpoint | Description |
|----------|-------------|
| `GET /api/promotions` | Promosi aktif (berdasarkan tanggal) |

## Testimonials

| Endpoint | Description |
|----------|-------------|
| `GET /api/testimonials` | Testimoni aktif (urut by rating) |

## FAQs

| Endpoint | Description |
|----------|-------------|
| `GET /api/faqs` | FAQ aktif |

## Settings

| Endpoint | Description |
|----------|-------------|
| `GET /api/settings` | Public settings (WA number, dll) |
