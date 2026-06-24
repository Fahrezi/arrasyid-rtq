# RTQ Ar-Rasyid — Project Documentation

**Aplikasi:** Platform donasi & manajemen keuangan Rumah Tahfidz Al-Qur'an Ar-Rasyid, Sawah Lunto  
**Stack:** Laravel 13, PHP 8.3+, Filament v3, Tailwind CSS v4, MySQL, Vite  
**Tanggal:** 2026-06-24

---

## Daftar Isi

1. [Arsitektur Umum](#1-arsitektur-umum)
2. [Database Schema](#2-database-schema)
3. [Relasi Antar Tabel](#3-relasi-antar-tabel)
4. [Alur Donasi Online](#4-alur-donasi-online)
5. [Alur Donasi Offline (Rekap Admin)](#5-alur-donasi-offline-rekap-admin)
6. [Alur Pengeluaran](#6-alur-pengeluaran)
7. [Integrasi Duitku](#7-integrasi-duitku)
8. [Admin Panel (Filament)](#8-admin-panel-filament)
9. [Routes](#9-routes)
10. [Konfigurasi & Environment](#10-konfigurasi--environment)

---

## 1. Arsitektur Umum

```
Browser (Visitor)
    │
    ▼
Homepage (Blade + Tailwind + Vanilla JS)
    │
    ├── Form Donasi → POST /donate → DonationController
    │                                      │
    │                              DuitkuService → Duitku API
    │                                      │
    │                              redirect → Duitku Payment Page
    │                                      │
    │                         POST /callback/duitku ← Duitku Webhook
    │
    └── Kegiatan / Laporan (read-only dari DB)

Browser (Admin)
    │
    ▼
Filament Admin Panel (/dashboard-arrasyiid)
    └── Kelola: Donatur, Program, Donasi, Pengeluaran, Kegiatan
```

---

## 2. Database Schema

### `users`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | |
| name | varchar | |
| email | varchar unique | |
| password | varchar | bcrypt |
| remember_token | varchar null | |
| created_at / updated_at | timestamp | |

---

### `donors`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | |
| name | varchar | Nama donatur |
| email | varchar null | Unik, dipakai `firstOrCreate` |
| phone | varchar null | No. WhatsApp |
| type | enum | `fix` = rutin, `non_fix` = tidak tetap |
| status | enum | `active`, `non_active` |
| notes | text null | Catatan internal admin |
| created_at / updated_at | timestamp | |

---

### `programs`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | |
| name | varchar | Nama program |
| slug | varchar unique | |
| description | text | |
| status | enum | `active`, `non_active`, `finish` |
| created_at / updated_at | timestamp | |

> Program `active` dipakai otomatis sebagai target donasi online.

---

### `donations`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | |
| donor_id | FK → donors | |
| program_id | FK → programs | |
| amount | decimal(15,2) | Nominal donasi |
| donated_at | timestamp | Waktu donasi |
| proof_of_donation | varchar null | Path file bukti |
| notes | text null | Pesan/doa dari donatur |
| status | enum | `pending`, `approved`, `rejected` |
| payment_method | enum | `bank_transfer`, `e_wallet`, `cash` |
| created_at / updated_at | timestamp | |

> **Immutable:** setelah tersimpan, tidak bisa diedit atau dihapus oleh siapapun.

---

### `duitku_payments`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | |
| merchant_order_id | varchar unique | Format: `RTQ-<UNIQID>` |
| donation_id | FK → donations | |
| amount | decimal(15,2) | |
| reference | varchar null | Reference dari Duitku |
| status | varchar | `pending`, `completed`, `failed` |
| payment_method | varchar null | Kode Duitku: `BC`, `M2`, dll |
| payment_url | text null | URL redirect ke Duitku |
| va_number | varchar null | Nomor VA jika metode VA |
| qr_string | text null | QR data jika metode QRIS |
| callback_payload | json null | Raw payload dari Duitku webhook |
| completed_at | timestamp null | Waktu pembayaran dikonfirmasi |
| created_at / updated_at | timestamp | |

---

### `expenses`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | |
| program_id | FK → programs | |
| name | varchar | Nama pengeluaran |
| amount | decimal(15,2) | |
| description | text | |
| expense_date | date | |
| proof_of_expense | varchar null | Path file bukti |
| is_confirmed | boolean | Default `false`; jika `true` → terkunci |
| deleted_at | timestamp null | Soft delete |
| created_at / updated_at | timestamp | |

> **Lock logic:** record bisa diedit/dihapus selama `is_confirmed = false`. Setelah dikonfirmasi → permanen, hanya soft delete.

---

### `activities`
| Kolom | Tipe | Keterangan |
|-------|------|-----------|
| id | bigint PK | |
| program_id | FK → programs | |
| name | varchar | Nama kegiatan |
| description | text | |
| activity_date | date | |
| proof_of_activity | varchar null | Path file dokumentasi |
| created_at / updated_at | timestamp | |

---

## 3. Relasi Antar Tabel

```
programs ──┬──< donations >── donors
           ├──< expenses
           └──< activities

donations ──< duitku_payments
```

| Model | Relasi | Target |
|-------|--------|--------|
| `Program` | hasMany | `Donation`, `Expense`, `Activity` |
| `Donor` | hasMany | `Donation` |
| `Donation` | belongsTo | `Donor`, `Program` |
| `Donation` | hasOne | `DuitkuPayment` |
| `DuitkuPayment` | belongsTo | `Donation` |
| `Expense` | belongsTo | `Program` |
| `Activity` | belongsTo | `Program` |

---

## 4. Alur Donasi Online

```
[Visitor] klik "Donasi Langsung"
    │
    ▼
Modal form terbuka
  Fields: Nama*, No. WA*, Email*, Jumlah*, Metode Pembayaran*, Pesan (opsional)
  Validasi client: nama ≥2 char, phone format 08xx, email regex, jumlah ≥10000
    │
    ▼
POST /donate (fetch, JSON)
    │
    ▼
DonationController@store
  1. Validate request (server-side)
  2. Cari Program status='active'  →  jika tidak ada → 422
  3. DB::transaction:
     a. Donor::firstOrCreate(['email']) → buat atau ambil donor
     b. Donation::create([status='pending'])
     c. DuitkuPayment::generateOrderId() → "RTQ-XXXXXXXX"
     d. DuitkuService::createInvoice(orderId, amount, customer, paymentMethod)
     e. DuitkuPayment::create([payment_url, va_number, qr_string, ...])
  4. Return JSON { payment_url }
    │
    ▼
Browser redirect → /donation/loading?redirect=<payment_url>
    │
    ▼
Loading page → redirect ke Duitku payment page
    │
    ▼
[User] bayar di Duitku
    │
    ▼
Duitku kirim webhook → POST /callback/duitku
    │
    ▼
DuitkuCallbackController@handle
  1. Verifikasi signature MD5
  2. Update DuitkuPayment: status='completed', completed_at, callback_payload
  3. Update Donation: status='approved'
    │
    ▼
Duitku redirect user → GET /donation/return
    │
    ▼
DonationReturnController: tampilkan halaman terima kasih
```

---

## 5. Alur Donasi Offline (Rekap Admin)

```
[Admin] buka Filament → menu Donasi → "Tambah"
    │
    ▼
Form donasi:
  - Pilih/buat Donatur (inline create tersedia)
  - Pilih Program
  - Isi Jumlah, Waktu, Metode (default: cash/approved)
  - Upload bukti (opsional)
    │
    ▼
Donation::create() langsung ke DB
  status = 'approved' (sudah diterima)
  DuitkuPayment tidak dibuat (offline)
    │
    ▼
Record tersimpan, tidak bisa diedit/dihapus
```

---

## 6. Alur Pengeluaran

```
[Admin] buka Filament → menu Pengeluaran → "Tambah"
    │
    ▼
Form: Program, Nama, Jumlah, Tanggal, Deskripsi, Bukti
  is_confirmed = false (default)
    │
    ▼
Record tersimpan → bisa diedit/dihapus selama is_confirmed=false
    │
    ▼
[Admin] klik tombol "Konfirmasi" pada baris record
  → Modal konfirmasi muncul
  → is_confirmed = true
    │
    ▼
Record terkunci:
  - Tombol Edit hilang
  - Tombol Hapus hilang
  - Bulk delete skip record ini
  - Soft delete saja (deleted_at terisi)
  - Data tetap di DB untuk audit
```

---

## 7. Integrasi Duitku

**Service:** `app/Services/DuitkuService.php`  
**Endpoint:** `POST {DUITKU_BASE_URL}/api/merchant/v2/inquiry`

### Request ke Duitku
```json
{
  "merchantCode": "DS32045",
  "paymentAmount": 100000,
  "paymentMethod": "BC",
  "merchantOrderId": "RTQ-XXXXXXXX",
  "productDetails": "Donasi RTQ Ar-Rasyid",
  "email": "donor@email.com",
  "customerVaName": "Nama Donor",
  "phoneNumber": "08123456789",
  "callbackUrl": "https://domain/callback/duitku",
  "returnUrl": "https://domain/donation/return",
  "expiryPeriod": 60,
  "signature": "md5(merchantCode + merchantOrderId + amount + apiKey)"
}
```

### Response Duitku
```json
{
  "paymentUrl": "https://sandbox.duitku.com/...",
  "vaNumber": "1234567890",
  "qrString": "...",
  "reference": "DEV..."
}
```

### Webhook Callback (Duitku → App)
```
POST /callback/duitku
Payload: merchantCode, amount, merchantOrderId, productDetail,
         additionalParam, paymentCode, resultCode, merchantUserId,
         reference, signature
Signature verify: md5(merchantCode + amount + merchantOrderId + apiKey)
```

### Kode Metode Pembayaran Duitku
| Kode | Metode |
|------|--------|
| BC | BCA Virtual Account |
| M2 | Mandiri Virtual Account |
| BT | Permata Virtual Account |
| I1 | BNI Virtual Account |
| BV | BSI Virtual Account |
| M1 | Maybank Virtual Account |
| OV | OVO |
| DA | DANA |
| SL | ShopeePay |
| LT | LinkAja |
| OL | QRIS |
| VC | Kartu Kredit (Visa/Mastercard) |
| A1 | Alfamart |

---

## 8. Admin Panel (Filament)

**URL:** `/dashboard-arrasyiid`  
**Auth:** User dengan `canAccessPanel()` = true  
**Akun default:** `admin@arrasyid.com`

### Resources

| Menu | Model | Create | Edit | Delete | Keterangan |
|------|-------|--------|------|--------|-----------|
| Donatur | Donor | ✅ | ✅ | ✅ | Full CRUD; tampil jumlah donasi per donor |
| Program | Program | ✅ | ✅ | ✅ | Full CRUD |
| Donasi | Donation | ✅ | ❌ | ❌ | Immutable setelah tersimpan |
| Pengeluaran | Expense | ✅ | ⚠️ | ⚠️ | Edit/hapus hanya saat `is_confirmed=false` |
| Laporan Kegiatan | Activity | ✅ | ✅ | ✅ | Full CRUD |
| Pembayaran | DuitkuPayment | — | — | — | Hidden dari nav; data teknis Duitku |

### Dashboard Widgets

| Widget | Isi |
|--------|-----|
| `MoneyFlowStatsWidget` | Total Donasi, Total Pengeluaran, Saldo Bersih, Program Aktif |
| `MoneyFlowChartWidget` | Line chart donasi vs pengeluaran 12 bulan terakhir |

---

## 9. Routes

| Method | URI | Name | Handler |
|--------|-----|------|---------|
| GET | `/` | — | Closure → `home` view |
| POST | `/donate` | `donate` | `DonationController@store` |
| POST | `/callback/duitku` | `callback.duitku` | `DuitkuCallbackController@handle` |
| GET | `/donation/loading` | `donation.loading` | `DonationReturnController@loading` |
| GET | `/donation/return` | `donation.return` | `DonationReturnController@handle` |
| — | `/dashboard-arrasyiid/*` | `filament.admin.*` | Filament Panel |

---

## 10. Konfigurasi & Environment

### `.env` Keys

| Key | Keterangan |
|-----|-----------|
| `APP_URL` | Harus match URL server (e.g. `http://localhost:8000`) |
| `DB_*` | MySQL: host, port, database, username, password |
| `DUITKU_MERCHANT_CODE` | Kode merchant dari dashboard Duitku |
| `DUITKU_API_KEY` | API key Duitku |
| `DUITKU_BASE_URL` | `https://sandbox.duitku.com/webapi` (sandbox) atau production URL |

### Storage

File upload disimpan di `storage/app/public/`:
- `donations/proofs/` — bukti donasi
- `expenses/proofs/` — bukti pengeluaran
- `activities/proofs/` — dokumentasi kegiatan

Akses publik via symlink: `php artisan storage:link`
