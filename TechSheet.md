PRODUCT REQUIREMENTS DOCUMENT (PRD)
Produk: LaundryOS (Multi-Tenant Laundry Management System) v1.0
Disusun oleh: Tim Engineering
Status: Draft Pre-Production
Tanggal: Mei 2024

1. Product Vision & Objectives
1.1. Vision Statement
Menjadi sistem operasional pusat (Single Source of Truth) yang mematikan human error di lantai workshop, memberikan visibilitas real-time kepada pemilik, dan mengubah pelanggan biasa menjadi pelanggan loyal melalui data dan otomasi WhatsApp.

1.2. Problem Statement (Yang Diselesaikan v1.0)
Human Error di Workshop: Pakaian tertukar, hilang, atau rusak karena tracking hanya mengandalkan tanda tangan manual atau ingatan staf.
Operasional Buta Warna: Pemilik tidak tahu stok bahan baku (deterjen, plastik) habis atau tidak, dan tidak tahu margin keuntungan riil per hari (HPP vs Omzet).
Komunikasi Fragmented: Konfirmasi terima/selesai ke pelanggan masih manual via WA pribadi kasir, sering terlewat.
Customer Retention Lemah: Tidak ada sistem yang secara otomatis menandai pelanggan yang hilang (churn) dan menghubungi mereka kembali.
1.3. Objectives v1.0 (MVP)
Mengimplementasikan State Machine tracking pakaian (dari terima sampai siap) berbasis scan Barcode/QR.
Mengotomatiskan notifikasi WhatsApp (dual-mode: Fonnte otomatis atau wa.me link via QR di struk) saat intake dan saat pakaian selesai.
Menyediakan Dashboard Pemilik yang menampilkan Laba Bersih Riil (pengurangan otomatis stok bahan baku).
Mengimplementasikan sistem Paket Prepaid, Membership Tier, dan Kompensasi (Complaint) yang terintegrasi.
2. Target Audience (User Personas)
Persona 1: Sari (Kasir / Frontliner)
Latar Belakang: Staf outlet, berhadapan langsung dengan pelanggan dan tumpukan pakaian masuk.
Pain Point: Pelanggan menumpuk, harus nulis manual di kertas lalu fotokirim WA, sering salah ketik berat/nomor WA.
Goal di LaundryOS: Input cepat, langsung cetak label — jika mode Fonnte, WA terkirim otomatis; jika wa.me, QR Code di struk untuk discan pelanggan. Kasir tidak perlu buka HP sama sekali.
Persona 2: Budi (Staf Workshop / Penyetrika)
Latar Belakang: Staf di area cuci dan setrika. Tidak peduli harga atau nama pelanggan, fokus pada "baju ini harus bagus".
Pain Point: Harus bolak-balik tanya kasir "ini baju siapa, noda apa, deterjen apa".
Goal di LaundryOS: Cukup arahkan scanner (HP/USB) ke barcode, layar langsung kasih instruksi (misal: Jangan dipress panas), tekan satu tombol "Selesai Setrika".
Persona 3: Pak Andi (Pemilik / Manajer)
Latar Belakang: Pemilik 3 outlet. Sibuk meeting supplier, tidak bisa setiap hari nongkrong di outlet.
Pain Point: Laporan keuangan dari kasir sering telat dan tidak akurat. Tidak tahu siapa staf yang lambat kerjanya.
Goal di LaundryOS: Buka HP pagi, lihat omzet kemarin, lihat stok deterjen tinggal berapa hari lagi, dan kirim promo WA ke pelanggan yang sudah 1 bulan tidak datang.
3. Core Modules & Functional Requirements
Module 1: Multi-Tenant Architecture (Foundation)
Fungsi: Memastikan data antar bisnis laundry terisolasi sempurna.

Fitur
Deskripsi
Priority
Tenant Resolution	Sistem membaca identitas tenant dari Subdomain (e.g., laundryku.laundryos.com) atau Header API (untuk Mobile App).	P0
Strict Data Isolation	Seluruh query database wajib menyertakan filter tenant_id secara otomatis (Global Scope).	P0
Custom Business Config	Setiap tenant bisa setting: harga default per kg, template WA, warna tema, dan formula bahan baku sendiri.	P1

Module 2: POS & Intake (Point of Sale)
Fungsi: Gerbang masuk data, harus zero-error.

Fitur
Deskripsi
Priority
Dual Mode Input	Mendukung input Kiloan (timbangan digital/manual) dan Satuan (per pcs dengan detail jenis baju, warna, brand).	P0
Auto Barcode Generation	Sistem generate kode unik (e.g., LND-240501-001) dan langsung mengirim payload ke printer thermal.	P0
Damage/Stain Documentation	Saat intake, kasir bisa input "Noda tinta" dan ambil foto bukti (disimpan terenkripsi).	P0
Payment Integration	Menerima Cash, QRIS (static/dynamic), dan saldo Deposit pelanggan.	P1

Module 3: Workshop Tracking & State Machine
Fungsi: Mematikan kebingungan di lantai produksi.

Fitur
Deskripsi
Priority
Strict State Transition	Status berjalan sekuensial: Received -> Washing -> Drying -> Ironing -> QC -> Packing -> Ready. Sistem menolak skip (misal: langsung dari Washing ke Packing).	P0
Scanner Agnostic Interface	UI yang dioptimalkan untuk input dari USB Barcode Scanner (mimik keyboard stroke) dan Kamera Smartphone (ZXing Library).	P0
Context-Aware Display	Saat barcode di-scan di pos setrika, layar hanya menampilkan instruksi setrika & catatan noda, menyembunyikan data harga.	P0
Employee Accountability	Setiap perpindahan status wajib terasosiasi dengan ID staf yang melakukan scan (Login PIN di tablet).	P1

Module 4: Inventory & HPP Automation
Fungsi: Menghitung laba bersih riil, bukan omzet kosong.

Fitur
Deskripsi
Priority
Formula-Based Deduction	Saat status berubah ke "Washing", sistem otomatis kurangi stok deterjen berdasarkan formula (e.g., 20ml/kg). Jika stok kurang, proses diblokir.	P0
Low Stock Alert	Dashboard pemilik menampilkan notifikasi merah jika stok kritis (mencapai batas minimum).	P0
Manual Opex Input	Pemilik input biaya tetap (listrik, gas, gaji) untuk menghitung Net Profit harian/bulanan.	P1

Module 5: CRM & WhatsApp Automation
Fungsi: Mesin penjualan yang bekerja 24/7.

Fitur
Deskripsi
Priority
Event-Driven WA Notifikasi	Notifikasi WA dikirim otomatis (via Fonnte) jika tenant mengaktifkan. Jika tidak, QR Code wa.me + link tracking dicetak di struk.	P0
Churn Prediction List	Query otomatis menampilkan pelanggan yang tidak transaksi dalam X hari (configurable).	P1
WA Blast Engine	Pemilik bisa pilih segmen pelanggan dan kirim promo. Jika mode Fonnte: blast otomatis via queue. Jika mode wa.me: generate daftar link yang tinggal diklik.	P1

Module 6: Complaint & Compensation System
Fungsi: Menangani keluhan tanpa menghancurkan reputasi.

Fitur
Deskripsi
Priority
Structured Reporting	Form lapor masalah: Pilih kategori (Hilang/Rusak), input kronologi, lampirkan foto.	P0
Investigation Workflow	Status flow: Reported -> Investigating -> Resolved. Terikat pada staf yang terlibat.	P1
Compensation Generator	Generate kompensasi berupa: Cashback saldo, Voucher Gratis Cuci, atau Potongan di order selanjutnya.	P1

Module 7: Membership & Packages
Fungsi: Menaikkan Customer Lifetime Value (CLV).

Fitur
Deskripsi
Priority
Tiering System (Auto)	Pelanggan naik tier (Regular -> Silver -> Gold) berdasarkan akumulasi total belanja. Tier memberikan diskon otomatis.	P1
Prepaid Packages	Produk paket (e.g., "10x Cuci Sepatu", "20 Kg Prepaid"). Kuota otomatis berkurang saat order.	P1
Package Expiration	Paket memiliki masa berlaku (e.g., 90 hari). Sistem auto-expire via Cron Job dan kirim notifikasi WA peringatan 7 hari sebelum habis.	P2

4. Non-Functional Requirements (NFR)
Kategori
Spesifikasi Teknis
Performance (POS)	Aksi "Simpan Order & Cetak Barcode" wajib di bawah 800ms. Scanner harus merespons di bawah 300ms.
Availability	Target Uptime 99.5%. Downtime maksimal di luar jam operasional (malam hari).
Offline Resilience	Jika koneksi internet di outlet putus, sistem scanner tetap bisa menerima scan dan menyimpannya di local cache (IndexedDB), lalu sync saat online.
Hardware Compatibility	Wajib bisa menerima input dari berbagai merek barcode scanner USB (HID mode) tanpa driver khusus.
Security	Data pelanggan (alamat, no HP) wajib di-encrypt di database. Foto bukti noda/rusak disimpan di storage terenkripsi (AES-256).

5. User Flow (Alur Utama)
Flow 1: Alur Operasional Harian (Zero-Error Loop)
Pelanggan Datang -> Kasir Timbang/Input -> Sistem Cetak Barcode & QR WA -> Ditempel ke Plastik -> Masuk Workshop -> Staf Cuci Scan (Layar: Cuci biasa) -> Staf Setrika Scan (Layar: Jangan pakai pewangi) -> Staf Packing Scan -> Status Ready -> Jika mode Fonnte: WA "Siap Diambil" otomatis terkirim. Jika wa.me: QR di struk discan pelanggan -> Kasir Scan saat Ambil -> Selesai.

Flow 2: Alur Komplain Pakaian Hilang
Pelanggan Komplain via WA -> Kasir input di sistem (Complaint Module) -> Status Order di-tandai Issue -> Admin cek CCTV/log scan terakhir -> Investigation selesai -> Admin generate Kompensasi (e.g., Saldo Rp 50.000) -> Saldo masuk ke dompet pelanggan -> Pelanggan pakai saldo di order berikutnya.

6. Out of Scope (TIDAK dibangun di v1.0)
Native Mobile App (iOS/Android): Fase awal menggunakan Web App responsif (PWA-lite) yang bisa di-Pin to Home Screen oleh pelanggan untuk tracking.
Integrasi Kurir Internal: Pengantaran menggunakan pihak ketiga (GoSend/Grab) atau kurir manual. Sistem hanya mengubah status menjadi "Delivering" secara manual.
Mesin Kasir POS Hardware (JDBC/OPOS): Tidak ada integrasi langsung ke laci kasir (Cash Drawer) di v1.0. Pembayaran cash dicatat sebagai akun piutang yang direkonciliasi nanti.
TECHNICAL ARCHITECTURE DOCUMENT (TAD)
Produk: LaundryOS v1.0
1. High-Level Architecture Overview
text

                         [ KASIR (PC) / STAF WORKSHOP (TABLET) / PEMILIK (HP) ]
                                              |
                                              v
+-----------------------------------------------------------------------------------+
|                           CLOUDFLARE (CDN & SECURITY)                             |
|  - SSL/TLS Termination                                                           |
|  - DDoS Protection                                                               |
|  - Static Asset Caching (React JS Bundle)                                        |
+-----------------------------------------------------------------------------------+
                                              |
                                              v
+-----------------------------------------------------------------------------------+
|                            LOAD BALANCER (NGINX)                                  |
|              - Reverse Proxy ke App Server                                        |
|              - WebSocket Proxying (untuk Real-time Updates)                       |
+-----------------------------------------------------------------------------------+
                                              |
                +-----------------------------+-----------------------------+
                v                                                           v
+--------------------------------+                     +--------------------------------+
|     APPLICATION SERVER 1       |                     |     APPLICATION SERVER 2       |
|        (PHP-FPM / FPM)         |         ...         |        (PHP-FPM / FPM)         |
|  +------------------------+   |                     |  +------------------------+   |
|  |      LARAVEL APP       |   |                     |  |      LARAVEL APP       |   |
|  |  - Tenant Middleware   |   |                     |  |  - Tenant Middleware   |   |
|  |  - State Machine Logic |   |                     |  |  - State Machine Logic |   |
|  |  - Inventory Deductor  |   |                     |  |  - Inventory Deductor  |   |
|  +------------------------+   |                     |  +------------------------+   |
|  +------------------------+   |                     |  +------------------------+   |
|  | LARAVEL REVERB (WS)    |   |                     |  | LARAVEL REVERB (WS)    |   |
|  |  - Real-time Events    |   |                     |  |  - Real-time Events    |   |
|  +------------------------+   |                     |  +------------------------+   |
+--------------------------------+                     +--------------------------------+
                |                                                           |
                +-----------------------------+-----------------------------+
                                              |
                                              v
+-----------------------------------------------------------------------------------+
|                               DATA & STORAGE LAYER                                |
|  +------------------+  +------------------+  +------------------+               |
|  |   MYSQL (Primary)|  |  REDIS           |  |  MINIO / S3      |               |
|  |   - Tenant Data   |  |  - Cache HPP     |  |  - Foto Bukti    |               |
|  |   - Order State   |  |  - Queue (WA)    |  |  - Label Barcode |               |
|  |   - Inventory     |  |  - WebSocket Pub |  |    (Encrypted)   |               |
|  +------------------+  +------------------+  +------------------+               |
+-----------------------------------------------------------------------------------+
                                              |
                                              v
+-----------------------------------------------------------------------------------+
|                           EXTERNAL SERVICES INTEGRATION                            |
|  - Fonnte API (WhatsApp Gateway — otomatis, jika tenant mengaktifkan)              |
|  - Fonnte API (WhatsApp Gateway — otomatis, configurable per tenant)               |
|  - wa.me Links (WhatsApp Link Generator — QR Code di struk, fallback default)      |
|  - Midtrans / Xendit (Opsional: Payment Gateway QRIS)                             |
+-----------------------------------------------------------------------------------+
2. Technology Stack Detail & Justification
Layer
Teknologi
Alasan Pemilihan untuk LaundryOS
Frontend	React.js (Vite) + Inertia.js + TailwindCSS	Inertia.js memberikan feel SPA tanpa membuat API terpisah. Kecepatan render sangat kritis untuk UI scanner yang tidak boleh ada lag.
State/Realtime	Laravel Echo + Reverb (Native WS)	Untuk update dashboard pemilik secara real-time tanpa reload, dan notifikasi alert stok habis.
Backend	Laravel 11 (PHP 8.2+)	Fitur Queue sangat dibutuhkan untuk proses asinkron seperti deduksi stok dan log audit tanpa memblokir proses simpan order di kasir.
Database	MySQL 8	Transaksi bersifat sangat relasional dan ketat. Membutuhkan row-level locking saat deduct stok bersamaan agar tidak terjadi race condition.
Cache & Queue	Redis	Menyimpan harga layanan per tenant, data tracking cache, antrian job deduksi stok, dan rate limiting.
File Storage	MinIO / S3 Compatible	Menyimpan foto bukti pakaian rusak/noda yang bersifat sensitif. Dipisah dari server utama.

3. Modular Architecture (Backend Laravel)
Struktur folder diorganisir berbasis Domain agar saat ada penambahan fitur (misal: integration mesin timbangan Bluetooth), tidak mengacak-acak kode inti.

text

app/
├── Modules/
│   ├── Tenant/              # Manajemen bisnis, konfigurasi, middleware isolation
│   ├── Pos/                 # Intake order, pencarian pelanggan, pembayaran
│   ├── Workshop/            # Barcode scanner endpoint, validasi state machine
│   ├── Inventory/           # Master bahan baku, formula, deduct stok, alert
│   ├── Notification/        # Template WA, Fonnte integration, wa.me link generator, queue jobs
│   ├── Complaint/           # Alur lapor, investigasi, kompensasi
│   ├── Membership/          # Tier kalkulasi, paket prepaid, voucher
│   └── Dashboard/           # Query agregasi untuk analytics pemilik
├── Services/                # Logika inti bisnis (StateTransitionService, HppCalculator)
└── Enums/                   # Definisi statis (OrderStatus, ComplaintStatus, CompensationType)
4. Core Technical Flows (Alur Kerja Sistem)
4.1. Alur State Machine & Inventory Deduction (Sangat Kritis)
Ini adalah jantung sistem. Transisi status tidak boleh gagal di tengah jalan.

Staf scan barcode di pos Cuci.
API menerima barcode, mencari order, melihat status saat ini adalah RECEIVED.
Sistem cek Allowed Transitions: Apakah RECEIVED boleh ke WASHING? (Ya).
Database Transaction BEGIN.
Update status order di tabel orders menjadi WASHING.
Sistem trigger Event StatusChanged.
Listener menjalankan Inventory Deduction: Hitung berat order * formula deterjen -> UPDATE raw_materials SET stock = stock - X WHERE id = Y.
Jika stok tidak cukup, sistem ROLLBACK transaksi, kembalikan status, dan kirim error ke tablet staf ("Stok deterjen habis, hubungi admin").
Jika berhasil, insert Log ke tabel order_status_logs (siapa, kapan, stasiun mana).
Database Transaction COMMIT.
4.2. Alur Notifikasi WhatsApp Dual-Mode (Fonnte + wa.me)
Alur tergantung setting WA provider di dashboard tenant.

Mode A — Fonnte (Otomatis via API):
Order berhasil di-commit ke database.
Sistem dispatch job SendWhatsAppJob ke Redis Queue.
Kasir langsung mendapat response sukses — printer cetak struk (total < 1 detik).
Di background, Worker PHP mengambil job, memformat pesan sesuai template tenant, kirim HTTP POST ke API Fonnte.
Jika Fonnte gagal (nomor tidak valid, token salah, kuota habis): Worker tandai log FAILED, kirim notifikasi merah ke dashboard kasir, tapi sistem tetap jalan normal.
Mode B — wa.me (Manual via QR di Struk):
Order berhasil di-commit ke database.
Sistem generate URL wa.me berdasarkan nomor HP & template WA tenant:
https://wa.me/628xxx?text=Halo%20...%20Pesanan%20(LND-001)%20telah%20kami%20terima.%20Cek%20progress%3A%20https%3A%2F%2Ftrack.laundryos.com%2FLND-001
Printer thermal mencetak struk yang menyertakan QR Code berisi link wa.me + link tracking.
Pelanggan scan QR Code untuk chat WA dan tracking. Kasir tidak perlu buka HP.
Gabungan: Struk selalu cetak QR wa.me sebagai fallback, bahkan saat mode Fonnte aktif — untuk jaga-jaga jika WA otomatis gagal.
4.3. Alur Real-time Dashboard (WebSocket)
Di outlet, status order berubah.
Server Laravel mem-broadcast Event OrderStatusChanged ke channel private tenant.{id}.
Browser Pemilik yang sedang membuka dashboard menerima event via WebSocket (Reverb).
Frontend React langsung memperbarui grafik Order in Progress tanpa reload halaman.
5. API Design Strategy
Menggunakan Inertia.js (Shared Controller), tetapi untuk kebutuhan Tablet Workshop yang murni scan, akan menggunakan API Endpoint khusus.

Authentication:

Kasir/Pemilik: Menggunakan Laravel Sanctum (Cookie Based SPA Auth).
Tablet Workshop: Menggunakan Laravel Sanctum (Token Based API Auth). Tablet login sekali pakai PIN, simpan token di LocalStorage.
Standard Response Format (untuk Workshop Scanner API):

json

// Sukses Scan
{
  "success": true,
  "data": {
    "order_code": "LND-240501-001",
    "current_status": "received",
    "next_action": "move_to_washing",
    "instructions": "Pewangi: Lavender. Pisahkan warna gelap.",
    "items_count": 5
  }
}

// Error (Business Logic - Contoh: Stok Habis)
{
  "success": false,
  "error_code": "INSUFFICIENT_MATERIAL",
  "message": "Gagal memulai pencucian",
  "details": "Stok Deterjen cair tersisa 100ml, dibutuhkan 200ml."
}
6. Caching Strategy
Data
Tempat Cache
Alasan
Tenant Config (Harga, Formula)	Redis (Forever, manual clear)	Di-load setiap request. Wajib super cepat.
Dashboard Analytics Harian	Redis (Cache 5 menit)	Query aggregasi berat (SUM, GROUP BY) tidak boleh dihitung berkali-kali jika pemilik refresh dashboard.
Low Stock Alert Matrix	Redis (Cache 1 jam)	Perhitungan estimasi hari habis (stok / rata-rata pemakaian) cukup diupdate setiap jam.

DATABASE DESIGN DOCUMENT (ERD)
LaundryOS v1.0
1. Domain: Multi-Tenant Core
sql

Table tenants {
  id bigint [pk, increment]
  name varchar(100)
  slug varchar(50) [unique] // Untuk subdomain routing
  business_config json // Harga default, formula bahan baku, template WA
  wa_provider enum('fonnte', 'wa_me') [default: 'wa_me'] // Pilihan provider WhatsApp
  wa_fonnte_token varchar(255) [nullable, encrypted] // Token API Fonnte (hanya jika wa_provider = 'fonnte')
  wa_link_template text // Template pesan WA untuk link wa.me (contoh: "Halo, pesanan {order_code} sudah siap")
  is_active boolean [default: true]
  created_at timestamp
}
2. Domain: Master Data & Users
sql

Table outlets {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  name varchar(100)
  is_workshop boolean [default: false]
  // Index: (tenant_id)
}

Table users (Karyawan & Admin) {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  outlet_id bigint [ref: > outlets.id]
  name varchar(100)
  pin_code varchar(6) // Untuk login cepat tablet workshop
  role enum('admin', 'cashier', 'washer', 'ironer', 'packer')
  is_active boolean [default: true]
  // Index: (tenant_id, outlet_id)
}

Table customers (Pelanggan) {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  name varchar(100)
  phone varchar(20) [unique per tenant]
  membership_tier_code varchar(20) [default: 'REGULAR']
  wallet_balance decimal(15,2) [default: 0] // Saldo deposit/kompensasi
  total_spent decimal(15,2) [default: 0] // Akumulasi untuk naik tier
  last_order_at timestamp
  // Index: (tenant_id, phone), (tenant_id, membership_tier_code)
}
3. Domain: Order & Workshop Tracking
sql

Table orders {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  order_code varchar(20) [unique] // LND-240501-001
  customer_id bigint [ref: > customers.id]
  outlet_id bigint [ref: > outlets.id]
  
  // Detail Layanan
  service_type enum('regular', 'express', 'dry_clean')
  is_per_piece boolean [default: false]
  total_weight_kg decimal(8,2)
  total_pieces int
  
  // Status State Machine
  status enum('received', 'washing', 'drying', 'ironing', 'quality_check', 'packing', 'ready', 'delivering', 'completed', 'cancelled')
  
  // Keuangan
  subtotal decimal(15,2)
  discount_amount decimal(15,2) [default: 0] // Dari voucher/member
  total_amount decimal(15,2)
  payment_method enum('cash', 'qris', 'wallet')
  payment_status enum('unpaid', 'paid')
  
  // Tracking Masalah
  has_issue boolean [default: false]
  
  received_at timestamp
  completed_at timestamp [nullable]
  
  // Index: (tenant_id, order_code), (tenant_id, status), (tenant_id, customer_id)
}

Table order_items (Untuk Layanan Satuan/Premium) {
  id bigint [pk, increment]
  order_id bigint [ref: > orders.id]
  item_code varchar(20) [unique] // Barcode per baju
  clothing_type varchar(50) // Kemeja, Celana, Sepatu
  color varchar(50)
  brand varchar(50) [nullable]
  stain_notes text [nullable]
  photo_path string [nullable] // Bukti noda saat intake
  status enum('received', 'washing', 'ironing', 'packing', 'ready', 'reported_damaged')
  // Index: (order_id), (item_code)
}

Table order_status_logs (Audit Trail Wajib) {
  id bigint [pk, increment]
  tenant_id bigint
  order_id bigint [ref: > orders.id]
  from_status varchar(50)
  to_status varchar(50)
  employee_id bigint [ref: > users.id]
  station varchar(50) // 'wash_station', 'iron_station'
  created_at timestamp
  // Index: (order_id, created_at)
}
4. Domain: Inventory & HPP
sql

Table raw_materials {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  name varchar(100) // Deterjen, Plastik, Pewangi
  unit varchar(20) // ml, kg, pcs
  current_stock decimal(15,2)
  min_stock_level decimal(15,2) // Trigger alert
  cost_per_unit decimal(15,2) // Untuk kalkulasi HPP
  // Index: (tenant_id)
}

Table material_formulas {
  id bigint [pk, increment]
  tenant_id bigint
  service_type varchar(50) // 'regular', 'express'
  raw_material_id bigint [ref: > raw_materials.id]
  consumption_per_kg decimal(10,4) // 0.020 liter per kg
  // Unique: (tenant_id, service_type, raw_material_id)
}

Table stock_movements {
  id bigint [pk, increment]
  tenant_id bigint
  raw_material_id bigint [ref: > raw_materials.id]
  type enum('in', 'out', 'adjustment')
  quantity decimal(15,2)
  reference_id bigint [nullable] // order_id jika 'out'
  notes text
  created_at timestamp
  // Index: (raw_material_id, created_at)
}
5. Domain: Complaint & Compensation
sql

Table complaints {
  id bigint [pk, increment]
  tenant_id bigint
  order_id bigint [ref: > orders.id]
  order_item_id bigint [ref: > order_items.id, nullable]
  reported_by bigint [ref: > users.id] // Kasir yang terima keluhan
  category enum('missing', 'damaged', 'late', 'other')
  description text
  status enum('reported', 'investigating', 'resolved', 'closed')
  root_cause enum('handling_error', 'wash_damage', 'lost', 'other') [nullable]
  evidence_photos json [nullable]
  created_at timestamp
  // Index: (tenant_id, status)
}

Table compensations {
  id bigint [pk, increment]
  tenant_id bigint
  complaint_id bigint [ref: > complaints.id]
  type enum('wallet_cashback', 'free_wash_voucher', 'discount_voucher')
  value decimal(15,2)
  voucher_code varchar(30) [unique, nullable]
  voucher_valid_until timestamp [nullable]
  used_at timestamp [nullable]
  // Index: (voucher_code)
}
6. Domain: Membership & Packages
sql

Table membership_tiers {
  id bigint [pk, increment]
  tenant_id bigint
  code varchar(20) // 'SILVER', 'GOLD'
  min_total_spent decimal(15,2)
  discount_percent decimal(5,2)
  // Index: (tenant_id)
}

Table package_products (Master Paket yang Dijual) {
  id bigint [pk, increment]
  tenant_id bigint
  name varchar(100) // "Paket Hemat 10 Kg"
  type enum('wash_kg', 'wash_piece', 'dry_clean')
  quota_details json // {"wash_kg": 10}
  price decimal(15,2)
  validity_days int // 90
  // Index: (tenant_id)
}

Table customer_packages (Paket yang Sudah Dibeli) {
  id bigint [pk, increment]
  tenant_id bigint
  customer_id bigint [ref: > customers.id]
  package_product_id bigint [ref: > package_products.id]
  remaining_quota json // {"wash_kg": 8}
  status enum('active', 'exhausted', 'expired')
  expires_at timestamp
  // Index: (customer_id, status)
}
🔑 Relational Map
[1] Tenant -> [N] Outlets, Users, Customers, Orders.
[1] Order -> [N] Order Items (Jika satuan).
[1] Order -> [N] Order Status Logs (Audit trail).
[1] Order -> [0..1] Complaints.
[1] Complaint -> [0..1] Compensations.
[N] Compensations (Voucher) -> [0..1] Orders (Saat voucher digunakan).
🛡️ Strategi Keamanan Database
Row-Level Security: Setiap Model wajib extends TenantModel yang memiliki Global Scope where('tenant_id', auth()->user()->tenant_id).
Optimistic Locking (Opsional v2): Pada tabel orders dan raw_materials tambahkan kolom version untuk mencegah race condition saat dua staf scan barcode bersamaan dan deduct stok di milidetik yang sama.
Soft Deletes: Wajib di tabel customers, orders, users. Data laundry tidak boleh dihapus fisik untuk keperluan investigasi polisi jika ada sengketa.
UI/UX FLOW & SCREEN SPECIFICATIONS
LaundryOS v1.0
A. USER FLOW OVERVIEW
Flow 1: Alur Kasir (Speed Focused)
Login PIN -> Dashboard Ringkas -> Klik "Order Baru" -> Ketik Nama/HP (Auto-complete pelanggan lama) -> Pilih Layanan (Reguler/Express/Satuan) -> Timbang / Input Jumlah -> Cek List Item Satuan (jika ada) -> Klik "Proses & Cetak" -> Printer Thermal keluar Label; jika mode Fonnte: WA otomatis terkirim; jika wa.me: QR Code wa.me & tracking di struk -> Selesai (Total waktu target: < 30 detik).

Flow 2: Alur Staf Workshop (Minimal Interaction)
Buka Tablet -> Halaman Scanner Full Screen (Kamera/USB aktif) -> Scan Barcode Plastik -> Layar menampilkan: Status: Cuci. Intruksi: Jangan dicampur putih. -> Staf kerjakan -> Scan Lagi untuk pindah pos -> Selesai.

Flow 3: Alur Pemilik (Insight Focused)
Buka Web di HP -> Login -> Langsung lihat Widget: Omzet Hari Ini, Laba Hari Ini, Stok Kritis Merah. -> Klik notifikasi "Stok Deterjen Habis" -> Klik "Beli/Restok" (nanti di v2) -> Klik Menu CRM -> Lihat list "Pelanggan Churn 30 Hari" -> Pilih semua -> Klik "Kirim Promo WA" -> Selesai.

B. DETAILED SCREEN SPECIFICATIONS
1. WORKSHOP PAGES (Tablet/Scanner - Prioritas UX Tertinggi)
WS-01: Universal Scanner View
Tujuan: Satu halaman untuk semua pos kerja (Cuci, Setrika, Packing). Tidak ada navigasi menu.
Komponen:
Scanner Area: 70% layar. Menampilkan feed kamera HP atau fokus ke input text tersembunyi (untuk USB Scanner).
Hasil Scan Card: Muncul dari bawah (Bottom Sheet) setelah barcode terdeteksi.
Header: Kode Order Besar (LND-001) + Warna Status saat ini (Biru Muda: Received).
Body: Instruksi spesifik (Font besar, jelas). Contoh: "PERINGATAN: Ada Noda Tinta di lengan kiri. Jangan dipress panas."
Jika ada foto noda, tampilkan thumbnail kecil yang bisa di-tap untuk zoom.
Aksi Button: Satu tombol besar mengisi layar lebar. Contoh: "✓ PINDAH KE SETRIKA". Warna sesuai aksi (Hijau jika maju, Merah jika lapor masalah).
Staf Identity: Kecil di pojok atas: "Login sebagai: Budi (Setrika)".
2. POS PAGES (Kasir - Desktop PC)
PS-01: POS Dashboard (Home)
Tujuan: Ringkasan cepat outlet hari ini.
Komponen:
Grid 4 angka besar: (1) Order Masuk Hari Ini, (2) Sedang Dikerjakan, (3) Siap Diambil, (4) Omset Kasir Saya.
Daftar "Siap Diambil" (Scroll list). Jika pelanggan ambil, kasir scan barcode -> status jadi Completed.
PS-02: Intake Form (Order Baru)
Tujuan: Menangkap data tanpa error.
Komponen:
Split Screen: Kiri (Form Input), Kanan (Riwayat Pelanggan jika auto-complete terpilih).
Smart Customer Input: Ketik "0812..." -> Dropdown muncul nama dan alamat pelanggan lama.
Mode Toggle: Tombol besar [ KILOAN ] [ SATUAN ]. Jika satuan, form bawah berubah jadi dynamic list (Tambah baju + dropdown jenis + input warna).
Instruction Box: Textarea khusus "Catatan untuk Workshop". Ini yang akan muncul di layar scanner staf.
Bottom Action Bar: Sticky di bawah. Total Harga (Bold) + Tombol [BATAL] [PROSES & CETAK LABEL].
3. OWNER DASHBOARD PAGES (Pemilik - Mobile First)
OW-01: Executive Summary
Tujuan: Jawaban dari pertanyaan "Uang saya hari ini berapa?".
Komponen:
Net Profit Card: Angka paling besar di halaman. Warna Hijau jika plus, Merah jika minus.
Revenue Breakdown: Donut Chart kecil (Cash vs QRIS).
Speed Metrics: "Rata-rata Waktu Pengerjaan Hari Ini: 18 Jam" (Dibandingkan target 24 jam).
Alert Banner: Jika ada stok kritis, muncul banner merah bergulir: "⚠️ Deterjen Cair tersisa untuk 5 kg lagi".
OW-02: Real-Time Workshop Monitor
Tujuan: Melihat kerja staf tanpa ada di tempat.
Komponen:
Kanban Board Style: Kolom: [Menunggu] [Cuci] [Setrika] [Packing] [Selesai].
Cards: Di dalam kolom ada card kecil berisi Kode Order + Jam masuk. Card bergerak realtime (WebSocket) saat staf scan di workshop.
Click to Expand: Tap card -> Muncul detail siapa pelanggannya, berapa kg, siapa staf yang terakhir handle.
OW-03: CRM & Blast Center — Dual-Mode WA
Tujuan: Mesin uang dari pelanggan lama.
Komponen:
Tab View: [Pelanggan VIP] [Tidak Aktif 30 Hari] [Pemegang Voucher].
List Checklist: Nama, HP, Terakhir cuci (Tanggal).
Action Area: Checkbox pilih pelanggan -> Dropdown Template Pesan (atau input manual).
- Mode Fonnte: Tombol [KIRIM WA SEKARANG] -> blast otomatis via queue, progress bar real-time.
- Mode wa.me: Tombol [SALIN SEMUA LINK] -> generate daftar link wa.me yang tinggal diklik manual.
4. ADMIN CONFIG PAGES (Manajer/Tenant Admin)
AD-00: Business Settings (NEW — WhatsApp & General Config)
Tujuan: Konfigurasi global bisnis laundry.
Komponen:
Tab WA Settings:
- Radio Button: [Fonnte (Otomatis)] [wa.me (Manual)]
- Jika pilih Fonnte, muncul field:
  • Token API Fonnte (password field, hidden)
  • Nomor HP Pengirim (optional, untuk reply)
  • Tombol [Test Kirim WA] — kirim WA test ke nomor admin
- Jika pilih wa.me, tampilkan preview template link: "wa.me/628xxx?text=Halo..."
- Field Template Pesan: untuk mode Fonnte (WA otomatis) dan wa.me (link), dengan variable: {order_code}, {customer_name}, {tracking_url}
- Tombol [Simpan] — update konfigurasi ke tenants.business_config
AD-01: Master Formula & Inventory
Tujuan: Setting otak sistem HPP dan pantau stok end-to-end.
Komponen:
Tabel Formula: Layanan Cuci Reguler butuh Deterjen sebanyak 0.020 l/kg.
Input Stok: Form restok manual (Tambah 5 Liter Deterjen).
Log Pemakaian: Tabel riil berapa deterjen yang terpakai hari ini (berdasarkan order yang statusnya sudah completed).
Restock Tab: Form input pembelian bahan baku — pilih bahan baku → input qty → harga beli → upload foto struk. Riwayat pembelian ditampilkan dalam tabel kronologis (tanggal, supplier, qty, harga beli, total).
Opname Tab: Tombol "Mulai Opname Baru" → sistem tampilkan tabel semua bahan baku dengan kolom "Stok Sistem" (readonly) dan "Stok Fisik" (input). Setelah submit, sistem hitung selisih dan minta alasan jika di luar toleransi. Riwayat opname dalam bentuk kartu per sesi.
AD-02: Complaint Handling
Tujuan: Resolvasi masalah pelanggan.
Komponen:
Form Lapor: Pilih Order (via search kode) -> Pilih Kategori (Hilang/Rusak) -> Upload Foto Bukti Jika Ada.
Timeline View: Riwayat status komplain mirip tracking paket.
Panel Kompensasi: Jika status Resolved, muncul form pilih tipe kompensasi. Jika pilih Saldo, system auto-generate voucher code dan update saldo pelanggan.
AD-03: Routing Config (NEW)
Tujuan: Mengelola hubungan outlet → workshop.
Komponen:
Tabel: Daftar Outlet Penerimaan → Workshop Tujuan (Default: Ya/Tidak).
Tombol "Tambah Routing": Pilih outlet → pilih workshop → centang "Jadikan Default".
Indikator: Workshop yang sedang melayani berapa banyak order (live count dari WebSocket).
RINGKASAN SITEMAP (Peta Navigasi)
text

├── /login (PIN Based)
│
├── /pos (Kasir PC)
│   ├── / (Dashboard POS)
│   ├── /orders/new (Intake Form)
│   └── /orders/:id/edit (Edit sebelum diproses workshop)
│
├── /workshop (Tablet - No Sidebar)
│   └── /scan (Universal Scanner View)
│
├── /dashboard (Pemilik Mobile)
│   ├── / (Executive Summary)
│   ├── /live (Realtime Workshop Monitor)
│   ├── /finance (Grafik Laba/Rugi)
│   ├── /inventory (Stok & Alert)
│   └── /crm (Pelanggan & WA Blast via wa.me)
│
└── /admin (Backoffice)
    ├── /settings (Konfigurasi Bisnis)
    ├── /inventory/master (Master Bahan & Formula)
    ├── /complaints (Daftar Komplain)
    ├── /memberships (Setting Tier & Paket)
    └── /pricing (MASTER DYNAMIC PRICING TIERS)
SECURITY REQUIREMENTS DOCUMENT (SRD)
LaundryOS v1.0
1. Threat Modeling
Tipe Ancaman
Deskripsi di Konteks LaundryOS
Dampak
Tenant Data Leak	Outlet A bisa membaca data pelanggan, omzet, atau staf Outlet B hanya dengan memanipulasi API request.	Fatal. Pelanggaran privasi massal & kehilangan trust klien B2B.
Race Condition (Stok)	Dua staf scan barcode di pos yang sama persis pada milidetik yang sama, menyebabkan pengurangan stok 2x padahal 1 order.	Korupsi data inventori, perhitungan HPP salah.
Scanner Injection	Seseorang memasukkan USB yang diprogram mengirimkan teks malicious sebanyak 1000x per detik ke input field scanner.	DoS pada tablet workshop, atau injeksi kode jika sanitasi gagal.
WA Token Theft (Mode Fonnte)	Hacker mengambil token API Fonnte milik Tenant, kemudian membanjiri pelanggan dengan spam menggunakan biaya tenant.	Kerugian finansial & reputasi bisnis hancur.
WA Link Spoofing (Mode wa.me)	Hacker memodifikasi parameter nomor HP di wa.me untuk mengirim pesan ke nomor yang tidak diinginkan.	Reputasi (risiko rendah karena wa.me hanya link, tidak ada biaya).

2. Tenant Isolation (Pilar Keamanan Utama)
Middleware Strictness: Middleware EnsureTenantIsolated wajib berjalan di setiap request (kecuali route login). Middleware akan melakukan abort(403) jika tidak bisa resolve tenant dari subdomain/header.
Global Scope Enforcement: Jangan pernah mematikan global scope tenant menggunakan Model::withoutGlobalScopes() kecuali di background job yang sudah di-hardcode tenant-nya.
URL/Route Protection: Saat mengakses /api/orders/1, sistem wajib mengecek apakah Order dengan ID 1 memang milik tenant_id yang sedang login. Jika bukan, langsung 404 Not Found (Jangan tunjukkan 403 untuk menghindari ID enumeration).
3. State Machine Integrity (Anti-Cheat Workshop)
Backend Dominance: Frontend (Tablet) hanya menampilkan tombol "Pindah ke Setrika". Yang menentukan apakah transisi ini valid adalah backend berdasarkan Enum AllowedTransitions.
No Skip Policy: Sistem tidak boleh menerima update langsung dari status WASHING ke PACKING melewati IRONING, meskipun frontend di-hack.
Audit Immutability: Tabel order_status_logs tidak boleh memiliki method update() atau delete() di Model-nya. Hanya boleh create().
4. Concurrency & Locking (Mengatasi Race Condition)
Pessimistic Locking (Database Level): Saat menjalankan deduct stok bahan baku di dalam transaksi, query update stok wajib menggunakan ->lockForUpdate().
Alur: SELECT current_stock FROM raw_materials WHERE id = 1 FOR UPDATE -> Cek di kode PHP -> UPDATE raw_materials SET current_stock = X. Ini memastikan jika Staf A dan Staf B scan bersamaan, Staf B akan menunggu hingga transaksi Staf A selesai.
Idempotency Key (Opsional v1.5): Untuk mencegah tablet mengirim request scan 2x karena jaringan wifi lambat (double tap).
5. API & Input Security (Scanner Safe)
Honeypot / Rate Limit: Endpoint API Scanner (/api/workshop/scan) diberi Rate Limit khusus: Maksimal 60 request per menit per IP/Device.
Input Sanitization: Hasil baca dari Barcode Scanner (yang本质上 adalah keyboard emulator) wajib di-sanitize. Hanya menerima karakter Alfanumerik dan strip -. Tolak jika mengandung special characters SQL/XSS (', <, >).
Payload Size Limit: Endpoint upload foto bukti noda/rusak dibatasi maksimal 2MB per foto, hanya MIME type image/jpeg atau image/png yang diizinkan.
6. Sensitive Data Protection
PII Encryption: Kolom customers.phone dan customers.address wajib di-encrypt menggunakan Laravel Casts (protected $casts = ['phone' => Encrypted::class]). Ini melindungi data pelanggan jika database server diretas (SQL Dump akan berisi string acak).
API Token Storage (Fonnte): Token API Fonnte milik tenant disimpan di kolom tenants.wa_fonnte_token menggunakan Encrypted Cast. Token hanya digunakan di background job, tidak pernah terekspos ke frontend.
Phone Number Validation: Setiap nomor HP wajib tervalidasi format internasional (628xx) sebelum masuk ke link wa.me atau API Fonnte. Mencegah link rusak atau API error karena nomor salah format.
Photo Storage Access: Foto di MinIO/S3 tidak boleh publik. Akses foto hanya boleh melalui backend menggunakan Signed URL yang berlaku 5 menit.
udah paling lengkap nih? 

Thought Process
Untuk level MVP (v1.0) yang siap kick-off ke tim developer, dokumen di atas sudah 95% sangat solid. Strukturnya sudah mengikuti standar industri (PRD, TAD, ERD, UI/UX, SRD), dan sudah menjawab semua requirement yang kamu berikan di awal (Multi-tenant, POS + Workshop, Dashboard, Kiloan/Satuan, Kamera/Scanner, Real-time, Complaint, Membership).

Tapi, kalo kita mau bikin sistem ini benar-benar "Bulletproof" (Enterprise Grade) dan nggak kalah sama produk SaaS laundry yang udah jadi (misal: WashOS, Positront, LaundryCare), ada 5 detail operasional mikro yang biasanya baru terasa nyebalkan saat udah live di lapangan.

Ini dia The Missing 5%-nya:

1. Skenario "Add-On" & "Split Order" (Operasional Harian)
Di lapangan, kasir sering menghadapi ini:

Add-On: Pelanggan datang, kasir udah input 5kg dan cetak barcode. 10 menit kemudian pelanggan balik bawa 1 kg lagi. Apakah bikin nota baru? Atau bisa add item ke barcode yang sama?
Split Service: Dalam 1 kantong plastik, ada 3kg baju biasa (Reguler) dan 1 jas (Dry Clean).
Cara mengatasinya di PRD: Perlu ditambahkan fitur Multi-Line Item di dalam 1 Order Code. Satu barcode bisa punya beberapa item dengan treatment berbeda, dan staf workshop bisa lihat "Item 1: Cuci Biasa, Item 2: Dry Clean" saat discan.
2. ESC/POS Protocol & Network Offline (Hardware Level)
Kamu bilang "printer thermal". Printer kasir murahan (seperti Epson TM82) itu bahasanya bukan PDF atau gambar, tapi ESC/POS (bahasa mesin jadul).

Masalah: Kalau printer keburu nyala sebelum server Laravel siap, cetakannya bakal jadi karakter aneh. Atau kalau kabel LAN putus, cara driver PC tahu printer offline?
Cara mengatasinya di TAD: Perlu spesifikasi teknis bahwa Frontend (React) harus mengirim raw string ESC/POS via Web Socket atau menggunakan library seperti electron-printer (kalau pakai desktop app) atau EscPosEncoder.js (kalau web). Backend tidak perlu handle cetak, biarkan Frontend yang langsung tembak ke Printer via IP local.
3. Shift Reconciliation & MDR Fee (Keuangan Mikro)
Pemilik butuh tahu uang fisik di laci kasir pas jam tutup.

Masalah: Omset QRIS 100rb, tapi yang masuk rekening pemilik cuma 98.500rb (karena potongan MDR 1.5%). Lalu kasir terima cash 200rb, tapi di laci cuma ada 150rb (kemana 50rbnya?).
Cara mengatasinya di ERD/UI: Perlu ada fitur "Kasir Shift Closing". Tabel baru cashier_shifts yang menyimpan saldo awal, total penerimaan cash, total penerimaan QRIS (bruto & netto setelah MDR), dan selisih fisik. Dashboard pemilik harus bisa lihat "Kas bon" per kasir.
4. Customer PWA (Pelanggan Juga Butuh Akses)
Kamu sebut "Smartphone bisa". Kalau ini cuma untuk staf (scanner), bagus. Tapi bagaimana dengan pelanggan?

Masalah: Pelanggan WA "Mas, status baju saya mana?" Kasir harus buka sistem, cari nama, balas WA. Ini melelahkan.
Cara mengatasinya di PRD: Perlu modul "Public Tracking Link". Di dalam WA notifikasi saat intake, ada link: laundryos.com/track/LND-240501-001. Pelanggan buka di HP (PWA), dia bisa lihat progres (Kotak-kotak: ✅Diterima -> ✅Dicuci -> ⏳Disetrika -> ⬜Packing) tanpa harus login.
5. Dynamic Pricing Matrix (Bukan Harga Flat)
Di PRD sekarang, asumsinya harga per kg itu datar (misal Reguler = 7.000/kg).

Masalah: Di dunia nyata, harganya bertingkat. Contoh: 1-3kg = 8.000/kg, 4-10kg = 7.000/kg, >10kg = 6.500/kg. Atau beda harga beda jenis pakaian (Sepatu = 15.000/pcs, Bed Cover = 25.000/pcs).
Cara mengatasinya di ERD: Perlu tabel pricing_tiers (berdasarkan berat minimum/maksimum) dan relasi harga spesifik di product_catalog (bukan cuma tagihan kiloan).
Kesimpulan:
Kalau tidak mau ada fitur Add-On, tidak pakai printer thermal lokal (pakai printer yang bisa cetak PDF dari browser saja), dan tidak mau repot soal closing kasir, maka Dokumen yang aku kasih di atas udah 100% FIX. Tinggal jilid dan kasih ke programmer.

Tapi kalau kamu mau aku inject 5 hal micro-detail ini ke dalam dokumen PRD/TAD/ERD di atas biar makin tebal dan anti-banding, bilang aja. Nanti aku update padahal tempatnya.

tambahkan public tracking link, harga jg customize dan ada tier2nya, Shift Reconciliation & MDR Fee (Keuangan Mikro), tambahin SC/POS Protocol & Network Offline (Hardware Level), Skenario "Add-On" & "Split Order" gas lah 

Thought Process
PRODUCT REQUIREMENTS DOCUMENT (PRD)
Produk: LaundryOS (Multi-Tenant Laundry Management System) v1.0
Disusun oleh: Tim Engineering
Status: Draft Pre-Production
Tanggal: Mei 2024

1. Product Vision & Objectives
1.1. Vision Statement
Menjadi sistem operasional pusat (Single Source of Truth) yang mematikan human error di lantai workshop, memberikan visibilitas real-time kepada pemilik, dan mengubah pelanggan biasa menjadi pelanggan loyal melalui data dan otomasi WhatsApp.

1.2. Problem Statement (Yang Diselesaikan v1.0)
Human Error di Workshop: Pakaian tertukar, hilang, atau rusak karena tracking hanya mengandalkan tanda tangan manual atau ingatan staf.
Operasional Buta Warna: Pemilik tidak tahu stok bahan baku (deterjen, plastik) habis atau tidak, dan tidak tahu margin keuntungan riil per hari (HPP vs Omzet).
Komunikasi Fragmented: Konfirmasi terima/selesai ke pelanggan masih manual via WA pribadi kasir, sering terlewat.
Customer Retention Lemah: Tidak ada sistem yang secara otomatis menandai pelanggan yang hilang (churn) dan menghubungi mereka kembali.
Rigidity POS: Tidak bisa menangani skenario order yang berubah di tengah jalan (add-on) atau satu nota dengan layanan berbeda (split).
Cash Flow Blindspot: Pemilik bingung antara Omzet Bruto vs Netto (karena potongan QRIS/MDR) dan kesenjangan fisik uang di kasir.
Hardware Friction: Ketergantungan pada koneksi internet yang putus-nyambung membuat printer thermal sering nge-lag atau error cetak.
Multi-Outlet Disconnect: Baju diterima di outlet cabang, dicuci di workshop pusat, dikembalikan ke cabang — tidak ada tracking logistik antar lokasi.
Stok Bisa Habis di Tengah Hari: Tidak ada alur restock/opname yang jelas, pemilik baru tahu stok habis saat transaksi sudah diblokir.
1.3. Objectives v1.0 (MVP)
Mengimplementasikan State Machine tracking pakaian (dari terima sampai siap) berbasis scan Barcode/QR dengan dukungan Multi-Line Items (Add-on & Split).
Mengimplementasikan Dynamic Pricing Matrix (Harga bertingkat berdasarkan berat/item).
Menyelaraskan cetak barcode menggunakan protocol ESC/POS langsung dari frontend dengan fallback offline.
Mengotomatiskan notifikasi WhatsApp (dual-mode: Fonnte otomatis atau wa.me link) dan menyediakan Public Tracking Link untuk pelanggan.
Menyediakan Dashboard Pemilik yang menampilkan Laba Bersih Riil (pengurangan otomatis stok & MDR).
Mengimplementasikan Shift Reconciliation untuk mengunci keuangan per kasir per shift.
Menyediakan fitur Restock & Stock Opname untuk memastikan ketersediaan bahan baku.
Mendukung skenario Multi-Outlet dengan routing logistik ke workshop pusat.
Menerapkan Smart Phone Validation dan Scanner Debounce untuk akurasi data input.
2. Target Audience (User Personas)
(Persona Sari, Budi, Pak Andi tetap sama seperti sebelumnya, ditambah satu persona baru)

Persona 4: Ibu Rina (Pelanggan)
Latar Belakang: Ibu rumah tangga yang rutin menyetorkan 5-10 kg baju per minggu.
Pain Point: Sering lupa apakah baju sudah diambil atau belum. Malu kalau harus WA kasir terus-menerus.
Goal di LaundryOS: Mau terima WA otomatis (jika mode Fonnte) atau scan QR di struk (jika wa.me), langsung lihat status baju di HP tanpa perlu login atau download aplikasi.
3. Core Modules & Functional Requirements
Module 1: Multi-Tenant Architecture (Foundation)
Fungsi: Memastikan data antar bisnis laundry terisolasi sempurna.

Fitur
Deskripsi
Priority
Tenant Resolution	Sistem membaca identitas tenant dari Subdomain (e.g., laundryku.laundryos.com) atau Header API (untuk Mobile App).	P0
Strict Data Isolation	Seluruh query database wajib menyertakan filter tenant_id secara otomatis (Global Scope).	P0
Custom Business Config	Setiap tenant bisa setting: harga default per kg, template WA, warna tema, formula bahan baku, cash rounding mode, PPN aktif/nonaktif.	P0
Multi-Outlet Routing	Jika tenant memiliki beberapa outlet penerimaan dan 1 workshop pusat, sistem mengarahkan order ke workshop yang ditentukan via tabel routing.	P1

Module 2: POS & Intake (Point of Sale) - UPDATED
Fungsi: Gerbang masuk data, harus zero-error dan fleksibel.

Fitur
Deskripsi
Priority
Dynamic Pricing Engine	Harga berubah otomatis saat kasir input berat. Contoh: 1-3kg -> 8.000/kg, 4-10kg -> 7.000/kg. Diambil dari Master Pricing per tenant.	P0
Multi-Line Items (Split Order)	Dalam 1 KodeNota, kasir bisa input: Baris 1 = Cuci Kiloan 5kg, Baris 2 = Dry Clean Jas 1pcs. Masing-masing punya treatment berbeda.	P0
Order Add-On Capability	Jika nota sudah dicetak/diproses, kasir bisa "Scan ulang nota tersebut" lalu tambahkan berat/items baru (akan mengupdate total harga secara rekursif).	P0
Auto ESC/POS Printing	Saat simpan, frontend langsung mengirim perintah mentah ke printer thermal via koneksi lokal (tanpa melewati backend server).	P0
Smart Phone Input & Validation	Input nomor HP auto-format ke 628xx, validasi regex /^62[0-9]{8,15}$/, tampilkan preview nama pelanggan saat mengetik.	P0
Cash Rounding (Pecahan Rupiah)	Saat pembayaran tunai, sistem membulatkan total otomatis (configurable: none/down_100/up_100/nearest_500) sesuai pecahan Rupiah yang beredar.	P1
Tax Inclusion (PPN)	Opsional PPN 11% per tenant. Sistem menambahkan tax_amount ke total dan menampilkan breakdown Include/Exclude PPN di struk & dashboard.	P1
Order Search & Lookup	Search bar multi-filter: cari order berdasarkan nama pelanggan, nomor HP, kode order, atau rentang tanggal.	P0

Module 3: Workshop Tracking & State Machine - UPDATED
Fungsi: Mematikan kebingungan di lantai produksi.

Fitur
Deskripsi
Priority
Item-Level State Tracking	Jika ada Split Order (Kiloan + Satuan), status bisa beda. Kiloan statusnya Ready, tapi Jas satuan masih Ironing. Status Header Order = "In Progress".	P0
Scanner Debounce & Idempotency	Setiap payload scan wajib mengandung UUID unik yang di-generate client. Backend menolak UUID duplikat. Client-side debounce 300ms + UI disable 1 detik setelah scan berhasil.	P0
Offline Scan Buffering	Jika WiFi workshop mati, scanner di tablet tetap menyimpan scan ke local memory. Saat WiFi balik, sistem auto-sync ke server (FIFO).	P1

Module 4: Inventory & HPP Automation - UPDATED
Fungsi: Menghitung laba bersih riil, mengelola stok end-to-end dari pembelian hingga pemakaian.

Fitur
Deskripsi
Priority
Formula-Based Deduction	Saat status berubah ke "Washing", sistem otomatis kurangi stok deterjen berdasarkan formula (e.g., 20ml/kg). Jika stok kurang, proses diblokir.	P0
Low Stock Alert	Dashboard pemilik menampilkan notifikasi merah jika stok kritis (mencapai batas minimum).	P0
Manual Opex Input	Pemilik input biaya tetap (listrik, gas, gaji) untuk menghitung Net Profit harian/bulanan.	P1
Restock / Purchase Receipt	Input pembelian bahan baku: bukti pembelian (foto struk), harga beli, kuantitas. Sistem update stok & simpan riwayat harga beli untuk kalkulasi HPP rata-rata.	P1
Stock Opname (Fisik vs Sistem)	Kasir/admin bisa memulai sesi hitung fisik. Sistem catat stok sistem saat itu, input stok fisik, hitung selisih. Jika selisih di luar toleransi, wajib input alasan.	P1
Usage vs Formula Variance Report	Laporan perbandingan: "Pemakaian Riil Deterjen Hari Ini = 5L vs Formula Seharusnya = 4.8L" untuk mendeteksi kebocoran atau kesalahan formula.	P2

Module 5: CRM, Tracking & WhatsApp Automation - UPDATED
Fungsi: Mesin penjualan yang bekerja 24/7 dan mengurangi beban kasir. Mendukung dual-mode WhatsApp: otomatis via Fonnte API (jika dikonfigurasi) atau manual via wa.me link.

Fitur
Deskripsi
Priority
Public Tracking Page	Halaman web statis (PWA-lite) yang bisa diakses siapa saja via URL unik (misal: track.laundryos.com/LND-001). Menampilkan Kanban status tanpa perlu login.	P0
Dual-Mode WA Notifikasi	Tenant bisa pilih provider WA di dashboard settings: (1) Fonnte — WA terkirim otomatis via API saat event trigger, (2) wa.me — QR Code di struk, pelanggan scan manual.	P0
Fonnte Auto-Send	Jika mode Fonnte aktif: sistem kirim WA otomatis via queue job saat order diterima & siap. Kasir tidak perlu repot. Gagal terkirim → log error + notifikasi dashboard.	P0
WA Link (Fallback)	Jika mode wa.me atau Fonnte gagal: struk tetap cetak QR Code berisi link wa.me + link tracking sebagai fallback. Pelanggan scan untuk chat & cek status.	P0
WA Blast Engine	Pemilik bisa pilih segmen pelanggan dan kirim promo. Jika mode Fonnte: blast otomatis via queue. Jika mode wa.me: generate daftar link yang tinggal diklik.	P1
Tracking Link & WA Link di Struk	Struk cetak menyertakan QR Code berisi link wa.me + link tracking. Pelanggan scan langsung chat & cek status.	P0

Module 6: Complaint & Compensation System
(Tetap sama)

Module 7: Membership & Packages
(Tetap sama)

Module 8: Cashier Shift & Micro-Finances (NEW)
Fungsi: Mengunci uang fisik dan menghitung biaya bancakan QRIS.

Fitur
Deskripsi
Priority
Shift Open/Close	Kasir wajib "Buka Shift" (input uang kas awal) sebelum bisa transaksi, dan "Tutup Shift" (hitung selisih fisik) di akhir.	P0
MDR Auto-Deduction	Sistem menerima Webhook dari Payment Gateway (Midtrans/Xendit). Jika pelanggan bayar QRIS 10.000, sistem catat Revenue 10.000, tapi Biaya MDR 150 (1.5%). Dashboard pemilik wajib tampilkan angka Netto ini.	P1
Shift Discrepancy Report	Sistem menghitung: Uang Fisik di Laci - (Saldo Awal + Cash Masuk - Cash Keluar). Jika selisih != 0, warna merah.	P1

4. Non-Functional Requirements (NFR) - UPDATED
Kategori
Spesifikasi Teknis
Performance (POS)	Aksi "Simpan Order & Cetak Barcode" wajib di bawah 800ms. Printer wajib mulai mencetak di bawah 1 detik.
Hardware (Printer)	Wajib mendukung ESC/POS protocol. Frontend wajib menggunakan Web Serial API atau soket lokal.
Offline Resilience	Jika internet mati, cetak struk/barcode TETAP BERHASIL (karena jalur lokal). Jika internet mati, scan workshop tetap bisa diterima di tablet dan di-queue.
Tracking Page Speed	Halaman Public Tracking wajib loading di bawah 2 detik di jaringan 3G/4G (menggunakan Server-Side Rendering / Static caching).
Input Validation	Nomor HP wajib tervalidasi format 628xx di client & server. Scanner input wajib di-debounce 300ms di client sebelum dikirim ke server.
Idempotency	Semua request mutasi wajib menyertakan X-Idempotency-Key (UUID). Backend menjamin exactly-once execution.
Data Backup	Automated daily backup MySQL ke S3/MinIO. Retensi 30 hari. Point-in-Time Recovery via binlog aktif.

5. User Flow (Alur Utama) - UPDATED
Flow 1: Alur Operasional Fleksibel (Add-On, Split & Dual WA)
Pelanggan datang -> Kasir input 5kg Kiloan Reguler -> Cetak Label (Total Rp 35.000) -> 1 Jam kemudian pelanggan bawa sepatu -> Kasir scan ulang nota -> Pilih "Tambah Item" -> Input Sepatu 1pcs -> Sistem generate barcode kedua untuk sepatu, update total nota jadi Rp 50.000 -> Di workshop, staf scan barcode baju (Status: Cuci), staf scan barcode sepatu (Status: Dry Clean).

Flow 2: Alur Pelanggan Tracking — Dual-Mode WA (Zero-Friction)
Kasir cetak struk + barcode.
Mode Fonnte: Sistem kirim WA otomatis ke HP pelanggan berisi pesan + link tracking.
Mode wa.me: Struk cetak QR Code berisi link wa.me + link tracking. Pelanggan scan untuk buka tracking.
Pelanggan buka link di HP -> Lihat kotak [✅ Diterima] [⏳ Dicuci] [⬜ Setrika] [⬜ Selesai] -> Pelanggan bisa tap "Hubungi Kami" untuk chat WA.
Besok pagi, pelanggan buka link yang sama, Kotak sudah hijau semua -> Datang ke outlet ambil tanpa perlu tanya-tanya.

Flow 3: Alur Tutup Kasir (Akuntabilitas)
Jam 22:00, kasir selesai -> Klik "Tutup Shift" -> Sistem tampilkan: "Total Cash yang harus ada di laci: Rp 1.500.000. Total QRIS (Bruto): Rp 2.000.000. Total QRIS (Netto setelah MDR): Rp 1.970.000" -> Kasir hitung fisik uang di laci, input angka aktual -> Sistem simpan laporan shift -> Pemilik bisa lihat laporan ini di dashboard HP pada malam yang sama.

6. Out of Scope (TIDAK dibangun di v1.0)
Native Mobile App (iOS/Android).
Integrasi Kurir Internal.
Otomatisasi Potongan Gaji Staf dari Selisih Kas. (Sistem hanya alert merah, pemotongan gaji dilakukan manual oleh admin HR).
Integrasi Timbangan Digital Bluetooth (Otomatis baca berat dari timbangan via Bluetooth). Di v1.0, berat diinput manual oleh kasir.
TECHNICAL ARCHITECTURE DOCUMENT (TAD)
Produk: LaundryOS v1.0
1. High-Level Architecture Overview - UPDATED
text

                    [ KASIR (PC) / STAF WORKSHOP (TABLET) / PELANGGAN (HP) ]
                                              |
       +--------------------------------------+--------------------------------------+
       |                                      |                                      |
       v                                      v                                      v
+---------------------------+   +--------------------------------+   +----------------------------------+
|   CLIENT-SIDE PRINTING    |   |        STANDARD WEB APP       |   |      PUBLIC TRACKING PWA        |
|   (ESC/POS DIRECT)        |   |     (Laravel + Inertia.js)    |   |     (Statik/SSR Cache)          |
|                           |   |                                |   |                                  |
| - EscPosEncoder.js        |   | - React UI                     |   | - Tidak ada JS berat             |
| - Web Serial API /        |   | - Cache (IndexedDB)            |   | - Baca data Order via API Public |
|   Local Sockets           |   | - Queue Sync (Background)      |   | - Cache Redis (5 menit)          |
+---------------------------+   +--------------------------------+   +----------------------------------+
       |                                      |                                      |
       v                                      v                                      v
+-----------------------------------------------------------------------------------+
|                           CLOUDFLARE (CDN & SECURITY)                             |
+-----------------------------------------------------------------------------------+
                                              |
                                              v
+-----------------------------------------------------------------------------------+
|                            LOAD BALANCER (NGINX)                                  |
+-----------------------------------------------------------------------------------+
                                              |
                +-----------------------------+-----------------------------+
                v                                                           v
+--------------------------------+                     +--------------------------------+
|     APPLICATION SERVER 1       |                     |     APPLICATION SERVER 2       |
|  +------------------------+   |                     |  +------------------------+   |
|  |      LARAVEL APP       |   |                     |  |      LARAVEL APP       |   |
|  |  - Dynamic Price Calc  |   |                     |  |  - Dynamic Price Calc  |   |
|  |  - Shift Rec Engine    |   |                     |  |  - Shift Rec Engine    |   |
|  +------------------------+   |                     |  +------------------------+   |
+--------------------------------+                     +--------------------------------+
                |                                                           |
                +-----------------------------+-----------------------------+
                                              |
                                              v
+-----------------------------------------------------------------------------------+
|                               DATA & STORAGE LAYER                                |
|  +------------------+  +------------------+  +------------------+               |
|  |   MYSQL (Primary)|  |  REDIS           |  |  MINIO / S3      |               |
|  |   - Pricing Tiers |  |  - Tracking Cache|  |                  |               |
|  |   - Shift Ledger  |  |   - Queue (Fonnte)|  |                  |               |
|  +------------------+  +------------------+  +------------------+               |
+-----------------------------------------------------------------------------------+
2. Technology Stack Detail & Justification - UPDATED
Layer
Teknologi
Alasan Pemilihan untuk LaundryOS
WA Gateway (Otomatis)	Fonnte API (via Queue)	Untuk tenant yang ingin WA notifikasi terkirim otomatis tanpa manual. Dikontrol via settings dashboard.
WA Gateway (Manual)	wa.me Link Generator	Default fallback. Gratis, tanpa API key. QR Code dicetak di struk untuk discan pelanggan.
Client Printer	esc-pos-encoder (JS Library) + Web Serial API / Electron	Menghindari lag cetak. PC kasir mengirim data biner langsung ke port USB printer tanpa routing via PHP Backend.
Offline Tablet	Workbox (Service Worker) + IndexedDB	Jika WiFi putus, scanner tetap menyimpan payload scan. Saat online, background sync mengirimnya ke server secara berurutan (FIFO).
Tracking Page	Laravel Blade (Server Side Rendering) + Redis Cache	Tidak menggunakan React/Inertia. Di-cache di Redis, sehingga load sangat kencang di HP pelanggan dan ramah SEO.
Backend	Laravel 11	State Machine, Queue (WA Fonnte), dan Webhook receiver (untuk MDR).

3. Core Technical Flows (Alur Kerja Sistem) - UPDATED
3.1. Alur Dynamic Pricing & Split Order
Kasir input berat 8kg, pilih "Reguler".
Frontend memanggil API GET /api/pricing/calculate?service=regular&weight=8.
Backend query service_pricing_tiers tenant tersebut. Menemukan rule: 4-10kg = 7.000.
Backend return {"subtotal": 56000}.
Kasir menekan Enter untuk pindah ke baris baru (Add Item). Input "Dry Clean Jas 1pcs".
Backend menghitung harga jas. Total keseluruhan dijumlahkan di Frontend.
Saat simpan, sistem generate 1 order_code (misal LND-001), tapi membuat 2 baris di tabel order_items. Masing-masing item mendapat item_code barcode fisik sendiri.
3.2. Alur Cetak ESC/POS (Tanpa Backend)
Frontend React berhasil menyimpan order ke Backend.
Backend return sukses + data payload order.
Frontend mem-parse data tersebut menjadi format ESC/POS (Mengatur ukuran font untuk Header, mencetak Barcode Code128, potong kertas).
Frontend membuka koneksi window.navigator.serial.requestPort() (Web Serial API).
Data biner dikirim langsung dari Browser Chrome ke port USB Printer. (Tidak menyentuh jaringan LAN/WAN sama sekali, sehingga 100% tidak terpengaruh mati listrik router).
3.3. Alur MDR Webhook & Shift Reconciliation
Pelanggan bayar via QRIS (Dynamic). Midtrans memproses.
Midtrans mengirim HTTP POST Webhook ke endpoint LaundryOS: /api/webhooks/payment.
LaundryOS menerima payload: {"order_id": "LND-001", "gross_amount": 10000, "merchant_fee": 150}.
Sistem update tabel order_payments (menyimpan gross & fee).
Saat kasir menutup shift, sistem tidak menghitung ulang MDR, tapi langsung SUM(merchant_fee) dari tabel order_payments di rentang waktu shift tersebut untuk ditampilkan di laporan.
3.4. Alur Scanner Debounce & Offline Sync dengan UUID
Staf scan barcode di tablet.
Client (JavaScript) menangkap input barcode, menjalankan debounce 300ms: jika ada input baru sebelum 300ms, timer di-reset (mencegah karakter dobel dari USB scanner murah).
Setelah yakin input lengkap, client generate UUID v4 unik untuk payload scan ini.
Client disable tombol aksi selama 1 detik (visual spinner/haptic feedback).
Payload dikirim ke Backend: POST /api/workshop/scan {"barcode":"LND-001","uuid":"abc-123","station":"wash"}.
Backend cek tabel idempotency_keys: jika UUID sudah ada, return 409 Conflict (scan sudah diproses).
Backend mulai transaksi state transition + inventory deduction.
Jika berhasil, simpan UUID ke idempotency_keys + COMMIT.
Jika koneksi gagal (offline), payload disimpan ke IndexedDB dengan status "pending".
Service Worker mendeteksi online balik dan mengirim payload FIFO (satu per satu) — jika salah satu gagal, antrian berhenti dan admin dapat notifikasi.
3.5. Alur Restock & Stock Opname
Restock: Admin buka menu Restok, pilih bahan baku, input kuantitas, harga beli, upload foto struk pembelian. Sistem simpan ke tabel purchase_receipts dan update current_stock di raw_materials.
Stock Opname: Admin klik "Mulai Opname". Sistem snapshot current_stock semua bahan baku ke tabel stock_opname_sessions. Admin input stok fisik. Sistem hitung selisih per item. Jika ada selisih di luar toleransi (configurable), wajib input alasan. Sistem simpan selisih dan buat adjustment otomatis.
4. API Design Strategy - UPDATED
Standard Response Format (Dynamic Price):

json

{
  "success": true,
  "data": {
    "items": [
      {
        "line_id": 1,
        "type": "kiloan",
        "detail": "Cuci Reguler",
        "qty_weight": 8,
        "price_per_unit": 7000,
        "subtotal": 56000
      },
      {
        "line_id": 2,
        "type": "satuan",
        "detail": "Dry Clean Jas",
        "qty_weight": 1,
        "price_per_unit": 25000,
        "subtotal": 25000
      }
    ],
    "grand_total": 81000
  }
}
Search Order API (Auth Required):

Endpoint: GET /api/pos/orders/search?q={query}&date_from={date}&date_to={date}&status={status}
Response: Array orders dengan data terbatas (kode, nama pelanggan, status, total, created_at).
Fitur: Search by nama pelanggan, no HP, atau kode order. Pagination 20 per halaman.
Dynamic Price API (Include PPN):

Endpoint: GET /api/pricing/calculate?service=regular&weight=8
Response dengan tambahan field tax:
json

{
  "success": true,
  "data": {
    "items": [...],
    "subtotal": 81000,
    "tax_percentage": 11.00,
    "tax_amount": 8910,
    "grand_total": 89910,
    "grand_total_rounded": 89900,
    "rounding_type": "down_100"
  }
}
Public API (Tanpa Auth):

Endpoint: GET /api/public/track/{order_code}
Response: Hanya mengembalikan status enum, daftar item, dan estimasi selesai. Tidak boleh mengembalikan harga, no HP pelanggan, atau data sensitif.
5. Caching Strategy - UPDATED
Data
Tempat Cache
Alasan
Public Tracking Data	Redis (Cache 2 menit)	Pelanggan sering refresh halaman tracking. Wajib disajikan dari cache, jangan hit DB.
Master Pricing Tiers	Redis (Forever)	Digunakan setiap kali kasir mengetik di POS. Wajib nol-delay.

6. DevOps & Deployment Strategy (NEW)
Infrastructure:
- Containerization: Docker + Docker Compose untuk development. Production menggunakan Laravel Forge / Ploi atau Kubernetes via DigitalOcean.
- Reverse Proxy: Nginx sebagai entry point, handle SSL termination, static asset cache.
- Database: MySQL 8 dengan automated daily backup ke S3/MinIO (retensi 30 hari). Binary log (binlog) aktif untuk Point-in-Time Recovery.
- Redis: Persistent configured, digunakan sebagai cache, queue, dan pub/sub WebSocket.
Zero-Downtime Deployment:
- Setiap deploy: build ulang Docker image, jalankan container baru di samping container lama. Nginx switch traffic setelah health check lolos.
- Migration: Laravel migration dijalankan sebelum container baru start (release phase).
CI/CD (Opsional v1.0):
- GitHub Actions / GitLab CI: otomatis run test, lint, build image, deploy ke staging.
Multi-Tenant Migration Strategy:
- Single database, multi-tenant via tenant_id column + Global Scope (pendekatan paling praktis untuk MVP).
- Jika scale > 100 tenant, migrasi ke database-per-tenant dengan sharding router di masa depan.
Monitoring & Error Tracking:
- Sentry/Laravel Telescope untuk error tracking & performance monitoring di semua environment.
- Uptime monitoring via Better Uptime / UptimeRobot (cek endpoint health /api/health).
- Logging: Laravel log ke stdout (Docker), dikumpulkan via Papertrail / Loki + Grafana.

DATABASE DESIGN DOCUMENT (ERD)
LaundryOS v1.0
1. Domain: Multi-Tenant Core & Master Data
(Tetap sama, berfokus pada perubahan di bawah ini)

1a. Domain: Core Tables — Update (NEW COLUMNS)
sql

-- Update tenants: tambah cash_rounding & tax config di business_config JSON
-- business_config JSON sekarang berisi:
-- {
--   "cash_rounding": "down_100",        // none | down_100 | up_100 | nearest_500
--   "tax_enabled": false,               // true = aktifkan PPN
--   "tax_percentage": 11.00,            // Persentase PPN
--   "default_price_per_kg": 7000,
--   "wa_template": "..."
-- }

-- Update customers: constraint phone format
-- phone disimpan dalam format 628xx (tanpa +, -, spasi)
-- Validasi regex di aplikasi: /^62[0-9]{8,15}$/

-- Update orders: tambah kolom pajak
-- grand_total decimal(15,2)          // Subtotal sebelum pajak
-- tax_percentage decimal(5,2) [default: 0]
-- tax_amount decimal(15,2) [default: 0]
-- final_total decimal(15,2)          // Setelah pajak + pembulatan
-- rounding_amount decimal(5,2) [default: 0]  // Selisih pembulatan cash

2. Domain: Outlet-to-Workshop Routing (NEW)
sql

Table outlet_workshop_routes {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  outlet_id bigint [ref: > outlets.id]        // Outlet penerimaan (cabang)
  workshop_id bigint [ref: > outlets.id]       // Workshop tujuan (is_workshop = true)
  is_default boolean [default: false]          // Routing default untuk outlet ini
  distance_km decimal(6,2) [nullable]          // Jarak untuk estimasi logistik
  created_at timestamp
  // Index: (tenant_id, outlet_id)
  // Note: Satu outlet bisa punya beberapa workshop (load balancing).
  // Saat order dibuat, sistem cek routing default. Jika ada beberapa, pilih yang dengan antrian paling sedikit.
}

3. Domain: Dynamic Pricing (NEW)
sql

Table service_pricing_tiers {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  service_type enum('regular', 'express', 'dry_clean', 'shoes', 'etc') // Jenis layanan
  
  // Logika Bertingkat
  min_qty decimal(10,2) [default: 0] // Batas bawah (misal 4 kg)
  max_qty decimal(10,2) [nullable]   // Batas atas (misal 10 kg, null = unlimited)
  
  price_per_unit decimal(15,2)       // Harga satuan pada tier ini (7000)
  
  created_at timestamp
  // Index: (tenant_id, service_type)
  // Note: Saat hitung harga, backend order by min_qty ASC, lalu cari di mana berat/qty jatuh di antara min dan max.
}
3. Domain: Order, Split & Add-Ons (REWORKED)
sql

Table orders {
  id bigint [pk, increment]
  tenant_id bigint [ref: > tenants.id]
  order_code varchar(20) [unique] // LND-240501-001 (1 Kode untuk semua item)
  customer_id bigint [ref: > customers.id]
  outlet_id bigint [ref: > outlets.id]
  cashier_shift_id bigint [ref: > cashier_shifts.id] // Binding ke shift kasir
  
  // Keuangan (Snapshot saat itu)
  grand_total decimal(15,2)
  discount_amount decimal(15,2) [default: 0]
  final_total decimal(15,2)
  
  // Status Header (Ditentukan oleh item-item di dalamnya)
  // Jika semua item = completed -> header = completed. Jika 1 masih washing -> header = in_progress.
  status enum('pending_payment', 'in_progress', 'ready', 'completed', 'cancelled')
  
  received_at timestamp
  completed_at timestamp [nullable]
  // Index: (tenant_id, order_code), (tenant_id, customer_id)
}

Table order_items (Sumber Kebenaran Item & Barcode) {
  id bigint [pk, increment]
  order_id bigint [ref: > orders.id]
  item_code varchar(20) [unique] // BARCODE FISIK YANG DITEMPEL DI BAJU
  line_type enum('kiloan', 'satuan')
  service_type varchar(50) // 'regular', 'dry_clean'
  
  // Detail Item
  total_weight_kg decimal(8,2) [nullable] // Diisi jika kiloan
  total_pieces int [default: 0]          // Diisi jika satuan
  clothing_details json [nullable]       // {"type": "Kemeja", "color": "Biru", "stain": "Noda tinta"}
  
  // Harga saat itu (Snapshot, agar jika admin ubah harga besok, history tidak berubah)
  price_per_unit decimal(15,2)
  line_subtotal decimal(15,2)
  
  // Status Individual (WORKSHOP TRACKING INI)
  status enum('received', 'washing', 'drying', 'ironing', 'packing', 'ready', 'completed', 'reported_issue')
  
  // Metadata
  is_add_on boolean [default: false] // True jika ditambahkan belakangan setelah order pertama kali dibuat
  created_at timestamp
  
  // Index: (order_id), (item_code)
}

Table order_status_logs (Tetap sama, tapi ref-nya ke order_items.id jika track per item, atau orders.id jika track keseluruhan)
4. Domain: Cashier Shift & MDR Micro-Finance (NEW)
sql

Table cashier_shifts {
  id bigint [pk, increment]
  tenant_id bigint
  outlet_id bigint [ref: > outlets.id]
  employee_id bigint [ref: > users.id] // Kasir yang jaga
  
  status enum('open', 'closed')
  opened_at timestamp
  closed_at timestamp [nullable]
  
  // Uang Fisik
  initial_cash_balance decimal(15,2) [default: 0] // Uang kas yang diisi kasir saat buka shift
  final_cash_counted decimal(15,2) [nullable]    // Uang kas yang dihitung kasir saat tutup shift
  cash_variance decimal(15,2) [nullable]         // SELISIH (final - expected). < 0 berarti kurang.
  
  // Index: (tenant_id, outlet_id, status)
}

Table order_payments (Detail Pembayaran per Order) {
  id bigint [pk, increment]
  tenant_id bigint
  order_id bigint [ref: > orders.id]
  cashier_shift_id bigint [ref: > cashier_shifts.id]
  
  payment_method enum('cash', 'qris', 'transfer', 'wallet')
  
  // Keuangan Mikro
  amount_gross decimal(15,2)       // Nominal yang dibayar pelanggan (100.000)
  mdr_fee decimal(15,2) [default: 0] // Potongan payment gateway (1.500 untuk QRIS)
  amount_net decimal(15,2)         // Nominal yang diterima pemilik (98.500)
  
  paid_at timestamp
  // Index: (order_id), (cashier_shift_id)
}
5. Domain: Inventory End-to-End (UPDATED — Tambah Restock & Opname)
sql

-- Tabel purchase_receipts (Riwayat Pembelian Bahan Baku)
Table purchase_receipts {
  id bigint [pk, increment]
  tenant_id bigint
  raw_material_id bigint [ref: > raw_materials.id]
  quantity decimal(15,2)                              // Jumlah yang dibeli
  unit_price decimal(15,2)                            // Harga beli per unit
  total_cost decimal(15,2)                            // quantity * unit_price
  receipt_photo_path string [nullable]                // Foto struk pembelian (MinIO/S3)
  notes text [nullable]                               // Catatan supplier
  purchased_at timestamp                              // Tanggal beli
  created_at timestamp
  // Index: (tenant_id, raw_material_id, purchased_at)
}

-- Tabel stock_opname_sessions (Sesi Hitung Stok Fisik)
Table stock_opname_sessions {
  id bigint [pk, increment]
  tenant_id bigint
  outlet_id bigint [ref: > outlets.id]
  performed_by bigint [ref: > users.id]               // Staf/admin yang melakukan opname
  status enum('in_progress', 'completed', 'cancelled')
  notes text [nullable]
  started_at timestamp
  completed_at timestamp [nullable]
  // Index: (tenant_id, outlet_id, status)
}

-- Tabel stock_opname_items (Detail per Bahan Baku dalam Sesi Opname)
Table stock_opname_items {
  id bigint [pk, increment]
  tenant_id bigint
  opname_session_id bigint [ref: > stock_opname_sessions.id]
  raw_material_id bigint [ref: > raw_materials.id]
  system_stock decimal(15,2)                          // Stok di sistem saat opname dimulai
  physical_stock decimal(15,2)                        // Stok hasil hitung fisik
  variance decimal(15,2)                              // physical - system (positif = lebih, negatif = kurang)
  tolerance decimal(15,2) [default: 0]                // Toleransi yang diizinkan (configurable per tenant)
  reason text [nullable]                              // Alasan jika variance di luar toleransi
  // Index: (opname_session_id)
}

-- Tabel idempotency_keys (Mencegah Double Scan & Double Submit)
Table idempotency_keys {
  id bigint [pk, increment]
  tenant_id bigint
  uuid varchar(36) [unique]                           // UUID dari client
  endpoint varchar(100)                               // Endpoint yang dipanggil
  response_status int                                 // HTTP status code hasil proses
  created_at timestamp
  // Index: (uuid), (tenant_id, created_at)
  // Note: Record dihapus otomatis via cron setelah 24 jam (TTL).
  // Note: Setiap request POST/PUT/PATCH wajib menyertakan header X-Idempotency-Key.
}

(Tabel Complaint, Membership tetap sama seperti dokumen sebelumnya)

🔑 Relational Map Update
[1] Order -> [1..N] Order Items (Sangat penting. Satu nota punya banyak barcode fisik).
[1] Order -> [1..N] Order Payments (Jika pembayaran dicicil atau mix cash+QRIS).
[1] Cashier Shift -> [N] Orders & Order Payments.
[1] Outlet -> [N] Outlet Workshop Routes -> [1] Workshop (Multi-outlet routing).
[1] Raw Material -> [N] Purchase Receipts (Riwayat pembelian & harga beli).
[1] Stock Opname Session -> [N] Stock Opname Items (Detail per bahan baku).
[1] Request (any) -> [0..1] Idempotency Keys (Cegah duplikasi).
UI/UX FLOW & SCREEN SPECIFICATIONS
LaundryOS v1.0
A. USER FLOW OVERVIEW
(Sudah terupdate di bagian PRD Flow 1, 2, 3)

B. DETAILED SCREEN SPECIFICATIONS
1. PUBLIC PAGES (Pelanggan - Tanpa Login)
PU-01: Public Tracking Page
Tujuan: Memberi visibilitas tanpa friksi.
Komponen:
Header Super Minimal: Logo Tenant (diambil dari config) + Kode Nota (LND-001).
Status Kanban Visual: 4 Kotak besar horizontal.
[✅ Diterima pada 09:00]
[✅ Dicuci pada 11:30]
[⏳ Sedang Disetrika]
[⬜ Packing]
Footer: Info alamat outlet & tombol "Hubungi Kami via WA" (link langsung ke wa.me/628xxx).
UX Rule: Tidak boleh ada menu lain. Tidak boleh ada iklan. Sangat bersih.
1a. POS PAGES (Kasir - Desktop PC) - UPDATED
PS-01: POS Dashboard (Home) — UPDATED
Tujuan: Ringkasan cepat outlet hari ini.
Komponen:
Grid 4 angka besar: (1) Order Masuk Hari Ini, (2) Sedang Dikerjakan, (3) Siap Diambil, (4) Omset Kasir Saya.
Search Bar: Pencarian order global — ketik nama/no HP/kode order. Dropdown hasil real-time dengan filter tambahan (tanggal, status). Klik hasil untuk buka detail order.
Daftar "Siap Diambil" (Scroll list). Jika pelanggan ambil, kasir scan barcode -> status jadi Completed.
PS-02: Intake Form (Order Baru & Dynamic Price)
Tujuan: Menangkap data kompleks tanpa membingungkan.
Komponen:
Dynamic Price Display: Di samping kanan input berat, ada angka yang berubah real-time saat kasir mengetik angka. "8 kg x Rp 7.000 = Rp 56.000".
Smart Customer Input: Ketik nomor HP — sistem auto-format ke 628xx, validasi format real-time (icon hijau/merah). Dropdown muncul nama & riwayat pelanggan lama.
Multi-Line Cart (Bawah): Sama seperti keranjang belanja.
Baris 1: "Cuci Reguler 8kg - Rp 56.000 [Hapus]"
Tombol [+ Tambah Layanan Lain di Nota Ini].
Tax Display: Jika tenant mengaktifkan PPN, tampilkan baris tambahan: "PPN 11%: Rp 8.910" + total setelah pajak.
Rounding Info: Jika pembayaran tunai, tampilkan: "Rp 35.250 → Dibulatkan Rp 35.000 (Tunai)" dengan ikon info.
Add-On Flow: Jika kasir scan nota yang sudah ada, sistem membuka keranjang yang lama, kasir klik "+ Tambah", input item baru, sistem menghitung selisih harga yang harus dibayar pelanggan.
PS-03: Shift Management Modal (NEW)
Tujuan: Mengamankan uang.
Komponen:
Buka Shift (Pagi): Pop-up wajib muncul saat kasir pertama kali masuk sistem. Input angka uang fisik di laci (misal: Rp 500.000).
Tutup Shift (Malam): Tombol di pojok kanan atas.
Ringkasan Shift:
Total Penjualan Cash: Rp 1.500.000
Uang Kas Awal: Rp 500.000
Uang yang HARUS ADA di Laci: Rp 2.000.000
Input Fisik: Kasir mengisi "Uang yang saya hitung sekarang: Rp ..."
Jika selisih != 0: Muncul teks merah besar "SELISIH KURANG RP 50.000" + Wajib isi field "Alasan Selisih" sebelum bisa klik "Proses Tutup Shift".
3. WORKSHOP PAGES (Tablet/Scanner) - UPDATED
WS-01: Universal Scanner View
Tujuan: Satu halaman untuk semua pos kerja.
Komponen Update:
Multi-Item Context: Jika kasir scan barcode nota (bukan item), layar menampilkan list semua item dalam nota tersebut beserta status masing-masing.
Offline Indicator: Ikon WiFi berubah jadi Ikon "Offline Mode" (abu-abu) dengan teks kecil "Data tersimpan lokal, akan sync otomatis".
Scan Feedback: Saat barcode terbaca, layar flash hijau (sukses) atau merah (gagal) selama 300ms. Tombol aksi disable selama 1 detik dengan spinner untuk mencegah double tap.
Outlet Routing Badge: Jika order berasal dari outlet berbeda dengan workshop (multi-outlet), tampilkan badge: "Dari Outlet: Cabang Merak" di pojok atas kartu hasil scan.
4. OWNER DASHBOARD PAGES (Pemilik - Mobile First) - UPDATED
OW-01: Executive Summary (Micro-Finance View)
Tujuan: Transparansi uang receh sekalipun.
Komponen Update:
Card Omzet Harian:
Baris 1: Bruto (Total Harga di Nota): Rp 5.000.000
Baris 1a (Jika PPN Aktif): "Termasuk PPN 11%: Rp 495.000" — toggle kecil [Include PPN] [Exclude PPN] untuk ganti tampilan.
Baris 2 (Font Lebih Kecil, Abu-abu): Pengurangan: Deterjen Rp 50.000, MDR QRIS Rp 75.000
Baris 3 (Font Tebal Hijau): NETT PROFIT: Rp 4.875.000
Alert Shift: Jika ada kasir yang tutup shift dengan selisih merah, muncul notifikasi di sini. "⚠️ Shift Malam Outlet A: Selisih kas kurang Rp 20.000".
Alert Inventory: Banner merah jika ada stok kritis atau selisih opname di luar toleransi. "⚠️ Selisih Opname: Deterjen Cair (sistem: 5L, fisik: 4.5L)".
RINGKASAN SITEMAP (Peta Navigasi)
text

├── /track/:order_code (PUBLIC - PWA Lite)
│
├── /login (PIN Based)
│
├── /pos (Kasir PC)
│   ├── / (Dashboard POS - + Search Bar)
│   ├── /orders/new (Intake Form - Dynamic Price + PPN + Rounding)
│   ├── /orders/search (Search & Filter Order)
│   └── /shift (Open/Close Shift Modal)
│
├── /workshop (Tablet - No Sidebar)
│   └── /scan (Universal Scanner View - Offline Ready + Debounce + Outlet Badge)
│
├── /dashboard (Pemilik Mobile)
│   ├── / (Executive Summary - Include MDR & Shift Alerts)
│   ├── /live (Realtime Workshop Monitor)
│   ├── /finance (Grafik Laba/Rugi Nett)
│   ├── /inventory (Stok & Alert)
│   └── /crm (Pelanggan & WA Blast via wa.me)
│
└── /admin (Backoffice)
    ├── /settings (Konfigurasi Bisnis - + PPN Toggle, Cash Rounding)
    ├── /pricing (MASTER DYNAMIC PRICING TIERS) <-- NEW
    ├── /inventory/master (Master Bahan & Formula - + Restock Tab, Opname Tab) <-- UPDATED
    ├── /inventory/restock (Form & Riwayat Pembelian Bahan Baku) <-- NEW
    ├── /inventory/opname (Sesi Hitung Stok Fisik) <-- NEW
    ├── /complaints (Daftar Komplain)
    ├── /memberships (Setting Tier & Paket)
    ├── /shifts (Riwayat Laporan Shift & Selisih Kas) <-- NEW
    └── /routing (Konfigurasi Outlet → Workshop) <-- NEW
SECURITY REQUIREMENTS DOCUMENT (SRD)
LaundryOS v1.0
(Bagian 1-4 sama seperti dokumen sebelumnya, fokus pada update berikut)

5. API & Input Security (Scanner Safe) - UPDATED
Honeypot / Rate Limit: Endpoint API Scanner (/api/workshop/scan) diberi Rate Limit khusus: Maksimal 60 request per menit per IP/Device.
Input Sanitization: Hasil baca dari Barcode Scanner (yang本质上 adalah keyboard emulator) wajib di-sanitize. Hanya menerima karakter Alfanumerik dan strip -. Tolak jika mengandung special characters SQL/XSS (', <, >).
Payload Size Limit: Endpoint upload foto bukti noda/rusak dibatasi maksimal 2MB per foto, hanya MIME type image/jpeg atau image/png yang diizinkan.
Idempotency Enforcement: Semua endpoint mutasi (POST/PUT/PATCH/PATCH) WAJIB menerima header X-Idempotency-Key (UUID). Backend menolak request dengan UUID yang sudah diproses (HTTP 409 Conflict). Ini mencegah double submit dari:
- Scanner USB yang mengirim karakter dobel (debounce gagal)
- Tablet offline yang mengirim payload yang sama 2x saat sync
- Double tap tombol oleh staf (UI disable adalah lapisan pertama, idempotency adalah lapisan kedua)
Client-Side Debounce: Wajib diimplementasikan di JavaScript (React):
- Setiap karakter dari barcode scanner di-buffer selama 300ms.
- Jika tidak ada karakter baru dalam 300ms, input dianggap lengkap.
- Jika ada karakter baru sebelum 300ms, timer di-reset (mencegah karakter dobel dari scanner murah).
- Setelah UUID dibuat dan payload siap, UI button aksi di-disable selama 1 detik.
Phone Number Validation:
- Setiap input nomor HP di POS wajib melalui validasi sisi client sebelum submit:
  - Auto-strip karakter non-digit (spasi, -, +, tanda kurung)
  - Jika diawali 0, ganti dengan 62 (08xxx → 628xxx)
  - Jika diawali +62, strip + (62xxx)
  - Validasi regex backend: /^62[0-9]{8,15}$/
- Jika nomor tidak valid, WAJIB tampilkan error spesifik di form (bukan hanya toast):
  "Nomor HP harus diawali 62 dan terdiri dari 10-13 digit. Contoh: 628123456789"
- Queue WA gagal karena nomor invalid tetap masuk log, dashboard kasir mendapat notifikasi merah.

6. Offline Queue & Reconciliation Security (NEW)
Fokus pada fitur Offline Buffering di tablet workshop.

State Conflict Resolution: Jika tablet offline selama 2 jam, staf scan 10x. Saat online, sistem menerima 10 payload berurutan. Jika ada anomali (misal: staf scan Packing lalu scan Washing karena tertukar tombol di layar), Backend WAJIB MENOLAK payload yang melanggar State Machine, dan menghentikan antrian sinkronisasi lokal tablet tersebut. Admin mendapat notifikasi "Gagal sync Tablet Pos Setrika".
No Duplicate Writes: Payload offline wajib memiliki ID unik (UUID) yang di-generate di tablet. Saat sync, Backend mengecek apakah UUID tersebut sudah pernah diproses (via tabel idempotency_keys). Ini mencegah double-input jika tablet mengirim data yang sama dua kali karena koneksi Wi-Fi half-open.
Idempotency Key TTL: Record idempotency_keys dihapus otomatis via cron job setelah 24 jam untuk menjaga performa tabel.
7. Financial Data Integrity (Shift & MDR)
Webhook Verification: Endpoint yang menerima update MDR dari Payment Gateway (Midtrans/Xendit) WAJIB memverifikasi Signature Header dari HTTP Request. Jangan pernah mempercayai IP Address semata.
Immutable Ledger: Tabel order_payments, cashier_shifts, purchase_receipts tidak boleh memiliki fungsi update() atau delete() di Model Eloquent-nya. Jika ada kesalahan input uang kas oleh kasir saat tutup shift, solusinya bukan edit data, tapi membuat record baru dengan tipe adjustment yang menghubungkan ke shift_id sebelumnya.
Public Tracking Data Stripping: Endpoint GET /api/public/track/{order_code} DIPASTIKAN tidak pernah melakukan query ke tabel order_payments, customers.phone, atau users. Hanya membaca tabel orders.status dan order_items.status untuk mencegah eksploitasi enumerasi harga oleh pihak ketiga.
8. Inventory & Stock Integrity (NEW)
Stock Deduction Locking: Saat deduct stok di transaksi Washing, gunakan Pessimistic Locking (FOR UPDATE) pada baris raw_materials. Jika dua staf scan di pos cuci bersamaan, baris kedua akan menunggu hingga transaksi pertama selesai (commit/rollback).
Opname Approval: Stock opname yang menghasilkan selisih di luar toleransi (configurable per tenant) tidak bisa langsung applied. Wajib ada approval dari pemilik/admin via notifikasi dashboard.
Restock Audit Trail: Setiap pembelian bahan baku (purchase_receipts) wajib mencatat: siapa yang input, kapan, harga beli, dan foto bukti. Ini untuk audit HPP di masa depan.