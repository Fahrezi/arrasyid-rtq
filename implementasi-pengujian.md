# Implementasi dan Pengujian Sistem Informasi Donasi RTQ Ar-Rasyid

---

## 1. Desain

Tahap desain merupakan fondasi pengembangan sistem informasi donasi RTQ Ar-Rasyid. Pada tahap ini dilakukan perancangan struktur basis data, arsitektur perangkat lunak, serta antarmuka pengguna sebelum proses implementasi dilaksanakan. Desain yang baik memastikan sistem dapat memenuhi kebutuhan fungsional secara transparan dan efisien, terutama dalam pengelolaan data donasi, program, pengeluaran, dan aktivitas lembaga.

---

### 1.1 Database

Basis data sistem dirancang menggunakan **SQLite** dengan pendekatan relasional. Terdapat sepuluh tabel yang saling berelasi, meliputi tabel inti domain bisnis maupun tabel pendukung sistem.

#### 1.1.1 Tabel `users`

Menyimpan data akun pengguna yang berhak mengakses panel admin sistem.

| Kolom               | Tipe Data                    | Keterangan                                           |
| ------------------- | ---------------------------- | ---------------------------------------------------- |
| `id`                | BIGINT, PK, Auto Increment   | Identitas unik pengguna                              |
| `name`              | VARCHAR                      | Nama lengkap pengguna                                |
| `email`             | VARCHAR, UNIQUE              | Alamat email sebagai identitas login                 |
| `email_verified_at` | TIMESTAMP, NULL              | Waktu verifikasi email; NULL jika belum diverifikasi |
| `password`          | VARCHAR                      | Kata sandi yang disimpan dalam bentuk hash bcrypt    |
| `role`              | ENUM(`super_admin`, `admin`) | Peran pengguna; default `admin`                      |
| `remember_token`    | VARCHAR, NULL                | Token sesi "ingat saya"                              |
| `created_at`        | TIMESTAMP                    | Waktu data dibuat                                    |
| `updated_at`        | TIMESTAMP                    | Waktu data terakhir diperbarui                       |

**Keterangan peran:**

- `super_admin` — memiliki akses penuh ke seluruh fitur dan konfigurasi sistem
- `admin` — pengurus RTQ yang dapat mengelola data operasional harian

---

#### 1.1.2 Tabel `donors`

Menyimpan data donatur yang telah berkontribusi kepada RTQ Ar-Rasyid.

| Kolom        | Tipe Data                    | Keterangan                            |
| ------------ | ---------------------------- | ------------------------------------- |
| `id`         | BIGINT, PK, Auto Increment   | Identitas unik donatur                |
| `name`       | VARCHAR                      | Nama lengkap donatur                  |
| `email`      | VARCHAR, NULL                | Alamat email donatur (opsional)       |
| `phone`      | VARCHAR, NULL                | Nomor telepon donatur (opsional)      |
| `type`       | ENUM(`fix`, `non_fix`)       | Jenis donatur: tetap atau tidak tetap |
| `status`     | ENUM(`active`, `non_active`) | Status keaktifan donatur              |
| `created_at` | TIMESTAMP                    | Waktu data dibuat                     |
| `updated_at` | TIMESTAMP                    | Waktu data terakhir diperbarui        |

**Keterangan jenis donatur:**

- `fix` — donatur yang berkomitmen berdonasi secara rutin/berkala
- `non_fix` — donatur yang berdonasi secara insidental atau sekali

---

#### 1.1.3 Tabel `programs`

Menyimpan data program kegiatan yang dijalankan oleh RTQ Ar-Rasyid. Program menjadi entitas pusat yang menghubungkan donasi, pengeluaran, dan kegiatan.

| Kolom         | Tipe Data                              | Keterangan                                                    |
| ------------- | -------------------------------------- | ------------------------------------------------------------- |
| `id`          | BIGINT, PK, Auto Increment             | Identitas unik program                                        |
| `name`        | VARCHAR                                | Nama program kegiatan                                         |
| `slug`        | VARCHAR, UNIQUE                        | Versi URL-friendly dari nama program (contoh: `tahfidz-anak`) |
| `description` | TEXT                                   | Deskripsi lengkap program                                     |
| `status`      | ENUM(`active`, `non_active`, `finish`) | Status berjalannya program                                    |
| `created_at`  | TIMESTAMP                              | Waktu data dibuat                                             |
| `updated_at`  | TIMESTAMP                              | Waktu data terakhir diperbarui                                |

**Keterangan status program:**

- `active` — program sedang berjalan dan menerima donasi
- `non_active` — program sementara dihentikan
- `finish` — program telah selesai dilaksanakan

---

#### 1.1.4 Tabel `donations`

Menyimpan setiap transaksi donasi yang masuk. Tabel ini menjadi penghubung utama antara donatur (`donors`) dan program (`programs`).

| Kolom               | Tipe Data                                 | Keterangan                                                |
| ------------------- | ----------------------------------------- | --------------------------------------------------------- |
| `id`                | BIGINT, PK, Auto Increment                | Identitas unik donasi                                     |
| `donor_id`          | BIGINT, FK → `donors.id`                  | Referensi ke donatur yang memberikan donasi               |
| `program_id`        | BIGINT, FK → `programs.id`                | Referensi ke program yang menerima donasi                 |
| `amount`            | DECIMAL(15,2)                             | Jumlah nominal donasi dalam Rupiah                        |
| `donated_at`        | TIMESTAMP                                 | Waktu donasi dilakukan                                    |
| `proof_of_donation` | VARCHAR, NULL                             | Path file bukti transfer yang diunggah donatur            |
| `notes`             | TEXT, NULL                                | Catatan tambahan dari donatur                             |
| `status`            | ENUM(`pending`, `approved`, `rejected`)   | Status verifikasi donasi; default `pending`               |
| `payment_method`    | ENUM(`bank_transfer`, `e_wallet`, `cash`) | Metode pembayaran yang digunakan; default `bank_transfer` |
| `created_at`        | TIMESTAMP                                 | Waktu data dibuat                                         |
| `updated_at`        | TIMESTAMP                                 | Waktu data terakhir diperbarui                            |

**Keterangan status donasi:**

- `pending` — donasi baru dikirim, menunggu verifikasi admin
- `approved` — donasi telah diverifikasi dan diterima
- `rejected` — donasi ditolak (contoh: bukti transfer tidak valid)

**Perilaku hapus (cascade):** Jika data donatur atau program dihapus, seluruh data donasi terkait ikut terhapus secara otomatis.

---

#### 1.1.5 Tabel `expenses`

Menyimpan data pengeluaran yang dilakukan dalam rangka pelaksanaan sebuah program.

| Kolom              | Tipe Data                  | Keterangan                                           |
| ------------------ | -------------------------- | ---------------------------------------------------- |
| `id`               | BIGINT, PK, Auto Increment | Identitas unik pengeluaran                           |
| `program_id`       | BIGINT, FK → `programs.id` | Referensi ke program yang menjadi sumber pengeluaran |
| `name`             | VARCHAR                    | Nama atau judul pengeluaran                          |
| `amount`           | DECIMAL(15,2)              | Jumlah nominal pengeluaran dalam Rupiah              |
| `description`      | TEXT                       | Keterangan detail mengenai pengeluaran               |
| `expense_date`     | DATE                       | Tanggal pengeluaran dilakukan                        |
| `proof_of_expense` | VARCHAR, NULL              | Path file bukti pengeluaran (nota, kwitansi, dll.)   |
| `created_at`       | TIMESTAMP                  | Waktu data dibuat                                    |
| `updated_at`       | TIMESTAMP                  | Waktu data terakhir diperbarui                       |

**Perilaku hapus (cascade):** Jika program dihapus, seluruh data pengeluaran terkait ikut terhapus.

---

#### 1.1.6 Tabel `activities`

Menyimpan data kegiatan yang dilaksanakan dalam suatu program, disertai dokumentasi visual sebagai bentuk pelaporan kepada donatur.

| Kolom               | Tipe Data                  | Keterangan                                  |
| ------------------- | -------------------------- | ------------------------------------------- |
| `id`                | BIGINT, PK, Auto Increment | Identitas unik kegiatan                     |
| `program_id`        | BIGINT, FK → `programs.id` | Referensi ke program yang menaungi kegiatan |
| `name`              | VARCHAR                    | Nama atau judul kegiatan                    |
| `description`       | TEXT                       | Deskripsi pelaksanaan kegiatan              |
| `activity_date`     | DATE                       | Tanggal kegiatan dilaksanakan               |
| `proof_of_activity` | VARCHAR, NULL              | Path file dokumentasi kegiatan (foto/video) |
| `created_at`        | TIMESTAMP                  | Waktu data dibuat                           |
| `updated_at`        | TIMESTAMP                  | Waktu data terakhir diperbarui              |

**Perilaku hapus (cascade):** Jika program dihapus, seluruh data kegiatan terkait ikut terhapus.

---

#### 1.1.7 Tabel `activity_reports`

Menyimpan data laporan rekap kegiatan. Tabel ini merupakan tabel yang dipersiapkan untuk pengembangan fitur laporan di masa mendatang.

| Kolom        | Tipe Data                  | Keterangan                     |
| ------------ | -------------------------- | ------------------------------ |
| `id`         | BIGINT, PK, Auto Increment | Identitas unik laporan         |
| `created_at` | TIMESTAMP                  | Waktu data dibuat              |
| `updated_at` | TIMESTAMP                  | Waktu data terakhir diperbarui |

---

#### 1.1.8 Tabel `duitku_payments`

Menyimpan data transaksi pembayaran yang diproses melalui payment gateway **Duitku**. Setiap donasi yang dibayar secara online memiliki satu record di tabel ini.

| Kolom               | Tipe Data                   | Keterangan                                              |
| ------------------- | --------------------------- | ------------------------------------------------------- |
| `id`                | BIGINT, PK, Auto Increment  | Identitas unik record pembayaran                        |
| `merchant_order_id` | VARCHAR, UNIQUE             | ID pesanan unik yang dikirim ke Duitku                  |
| `donation_id`       | BIGINT, FK → `donations.id` | Referensi ke donasi yang dibayarkan                     |
| `amount`            | DECIMAL(15,2)               | Jumlah tagihan pembayaran dalam Rupiah                  |
| `reference`         | VARCHAR, NULL               | Nomor referensi transaksi dari Duitku                   |
| `status`            | VARCHAR                     | Status transaksi dari Duitku; default `pending`         |
| `payment_method`    | VARCHAR, NULL               | Kode metode pembayaran yang dipilih (VA, QRIS, dsb.)    |
| `payment_url`       | TEXT, NULL                  | URL halaman pembayaran Duitku yang diberikan ke donatur |
| `va_number`         | VARCHAR, NULL               | Nomor Virtual Account jika metode pembayaran adalah VA  |
| `qr_string`         | TEXT, NULL                  | String data QRIS jika metode pembayaran adalah QRIS     |
| `callback_payload`  | JSON, NULL                  | Seluruh data callback yang diterima dari Duitku         |
| `completed_at`      | TIMESTAMP, NULL             | Waktu pembayaran berhasil dikonfirmasi                  |
| `created_at`        | TIMESTAMP                   | Waktu data dibuat                                       |
| `updated_at`        | TIMESTAMP                   | Waktu data terakhir diperbarui                          |

**Perilaku hapus (cascade):** Jika data donasi dihapus, record pembayaran Duitku terkait ikut terhapus.

---

#### 1.1.9 Tabel `pakasir_payments`

Menyimpan data transaksi yang pernah diproses melalui payment gateway **Pakasir** (digunakan pada versi awal pengembangan, kemudian digantikan oleh Duitku).

| Kolom             | Tipe Data                                         | Keterangan                                      |
| ----------------- | ------------------------------------------------- | ----------------------------------------------- |
| `id`              | BIGINT, PK, Auto Increment                        | Identitas unik record pembayaran                |
| `order_id`        | VARCHAR, UNIQUE                                   | ID pesanan unik yang dikirim ke Pakasir         |
| `donation_id`     | BIGINT, FK → `donations.id`, NULL                 | Referensi ke donasi; bisa NULL                  |
| `amount`          | DECIMAL(15,2)                                     | Jumlah tagihan pembayaran dalam Rupiah          |
| `project`         | VARCHAR                                           | Kode proyek Pakasir yang digunakan              |
| `status`          | ENUM(`pending`, `completed`, `failed`, `expired`) | Status transaksi; default `pending`             |
| `payment_method`  | VARCHAR, NULL                                     | Metode pembayaran yang dipilih                  |
| `payment_url`     | VARCHAR, NULL                                     | URL halaman pembayaran Pakasir                  |
| `qr_string`       | TEXT, NULL                                        | String data QRIS jika metode QRIS               |
| `va_number`       | VARCHAR, NULL                                     | Nomor Virtual Account jika metode VA            |
| `webhook_payload` | JSON, NULL                                        | Seluruh data webhook yang diterima dari Pakasir |
| `completed_at`    | TIMESTAMP, NULL                                   | Waktu pembayaran berhasil dikonfirmasi          |
| `created_at`      | TIMESTAMP                                         | Waktu data dibuat                               |
| `updated_at`      | TIMESTAMP                                         | Waktu data terakhir diperbarui                  |

**Perilaku hapus:** Jika data donasi dihapus, kolom `donation_id` pada tabel ini diset menjadi NULL (tidak ikut terhapus).

---

#### 1.1.10 Relasi Antar Tabel

Diagram berikut menggambarkan relasi antar tabel dalam basis data sistem:

```
users
  (tidak berelasi langsung dengan tabel domain, hanya untuk autentikasi admin)

donors ──────────────────────────┐
                                 │ 1:N
                              donations ──────── duitku_payments (1:1)
                                 │               pakasir_payments (1:1, nullable)
programs ────────────────────────┘
   │
   ├── 1:N ── expenses
   │
   └── 1:N ── activities
```

**Penjelasan relasi:**

| Relasi                           | Jenis                      | Keterangan                                                        |
| -------------------------------- | -------------------------- | ----------------------------------------------------------------- |
| `donors` → `donations`           | One-to-Many (1:N)          | Satu donatur dapat melakukan banyak donasi di waktu yang berbeda  |
| `programs` → `donations`         | One-to-Many (1:N)          | Satu program dapat menerima banyak donasi dari berbagai donatur   |
| `programs` → `expenses`          | One-to-Many (1:N)          | Satu program dapat memiliki banyak catatan pengeluaran            |
| `programs` → `activities`        | One-to-Many (1:N)          | Satu program dapat memiliki banyak kegiatan yang dilaksanakan     |
| `donations` → `duitku_payments`  | One-to-One (1:1)           | Satu donasi memiliki tepat satu record transaksi Duitku           |
| `donations` → `pakasir_payments` | One-to-One (1:1), nullable | Satu donasi dapat memiliki satu record transaksi Pakasir (legacy) |

**Catatan integritas data:** Seluruh relasi yang menggunakan `cascade delete` memastikan bahwa ketika data induk dihapus, seluruh data turunan ikut dihapus secara otomatis oleh basis data, sehingga tidak ada data anak yang menggantung (_orphan records_).

---

### 1.2 Software Architecture

Sistem dibangun menggunakan arsitektur **MVC (Model-View-Controller)** berbasis framework **Laravel 13** dengan PHP 8.4. Arsitektur dibagi menjadi dua lapisan utama:

1. **Panel Admin** — menggunakan **Filament 3.3**, sebuah admin panel berbasis Laravel yang menyediakan antarmuka CRUD untuk pengelolaan data donatur, donasi, program, pengeluaran, dan aktivitas. Panel admin dapat diakses melalui rute `/dashboard-arrasyiid` dengan sistem autentikasi bawaan Filament.

2. **Antarmuka Publik** — halaman yang dapat diakses oleh donatur tanpa autentikasi, mencakup halaman utama, alur donasi, serta halaman konfirmasi pembayaran.

Sistem juga mengintegrasikan **Duitku Payment Gateway** untuk memproses transaksi donasi secara online. Integrasi ini melibatkan pembuatan invoice, proses _callback_ dari Duitku, dan halaman _return_ setelah pembayaran selesai. Aset frontend dikelola menggunakan **Vite** dengan **Tailwind CSS v4**.

---

### 1.3 User Interface

Antarmuka pengguna dirancang dengan dua konteks penggunaan:

1. **Halaman Publik** — ditujukan untuk donatur dan pengunjung umum. Terdiri dari halaman beranda yang menampilkan informasi lembaga, program aktif, dan tombol donasi. Tampilan menggunakan tipografi kustom (_Josefin Sans_ dan _Funnel Sans_) dengan warna hijau sebagai warna utama yang mencerminkan identitas lembaga Islam. Halaman donasi menampilkan formulir pengisian data donatur dan pilihan nominal donasi, yang selanjutnya diarahkan ke halaman pembayaran Duitku.

2. **Panel Admin** — ditujukan untuk pengurus RTQ Ar-Rasyid. Menyediakan tampilan manajemen data dalam bentuk tabel dengan fitur pencarian, paginasi, serta formulir tambah dan ubah data. Panel admin dibangun secara deklaratif menggunakan Filament Resource sehingga tampilan bersifat konsisten dan responsif.

Seluruh antarmuka menggunakan **Bahasa Indonesia** sebagai bahasa antarmuka utama.

---

## 2. Code Generation

Proses pembuatan kode pada sistem ini memanfaatkan fitur _code generation_ yang disediakan oleh framework Laravel dan Filament. Skema basis data dibuat menggunakan **Laravel Migrations**, memungkinkan definisi struktur tabel secara terprogram dan dapat direproduksi di berbagai lingkungan. Model Eloquent dibuat untuk setiap entitas data (Donor, Donation, Program, Expense, Activity, DuitkuPayment) beserta relasi antar-model. Filament Resource digunakan untuk secara otomatis menghasilkan halaman CRUD admin — termasuk halaman daftar, tambah, dan ubah data — cukup dengan mendefinisikan kolom dan form field secara deklaratif di kelas Resource. Integrasi payment gateway diimplementasikan melalui kelas `DuitkuService` yang menangani pembuatan invoice dan verifikasi _callback signature_ menggunakan HMAC MD5.

---

## 3. Testing

Pengujian sistem dilakukan menggunakan framework **Pest 4.7**, sebuah testing framework modern berbasis PHP yang berjalan di atas PHPUnit. Pengujian dibagi menjadi dua kategori:

- **Unit Test** — menguji fungsi dan logika bisnis secara terisolasi, seperti logika kalkulasi donasi dan verifikasi signature Duitku
- **Feature Test** — menguji alur sistem secara menyeluruh, termasuk alur donasi, proses callback payment gateway, dan akses panel admin

Pengujian dijalankan menggunakan perintah `php artisan test` yang secara otomatis membersihkan konfigurasi cache sebelum eksekusi. Seluruh pengujian dijalankan pada lingkungan _testing_ yang terpisah dari lingkungan produksi untuk memastikan data pengujian tidak mempengaruhi data asli.

---

## 4. Support

### 4.1 Publikasi Software

Sistem dipublikasikan menggunakan platform **Railway**, sebuah layanan _Platform as a Service_ (PaaS) berbasis cloud. Konfigurasi deployment didefinisikan menggunakan file **railpack.json** yang menentukan versi PHP (8.4) serta seluruh dependensi sistem operasi yang dibutuhkan, seperti pustaka SSL, SQLite, ICU, dan GD untuk pemrosesan gambar. Proses deployment dilakukan secara otomatis melalui integrasi dengan repositori Git. Aplikasi dapat diakses secara publik melalui domain yang disediakan Railway tanpa memerlukan pengelolaan server secara manual.

---

### 4.2 Spesifikasi Hardware dan Software

**Spesifikasi Software:**

| Komponen             | Versi / Keterangan    |
| -------------------- | --------------------- |
| PHP                  | 8.4                   |
| Laravel Framework    | 13.8                  |
| Filament Admin Panel | 3.3                   |
| Database             | SQLite                |
| Tailwind CSS         | v4                    |
| Vite                 | Bundler aset frontend |
| Pest (Testing)       | 4.7                   |
| Payment Gateway      | Duitku API v2         |
| Deployment Platform  | Railway (PaaS)        |

**Spesifikasi Hardware (Server):**
Sistem berjalan di infrastruktur cloud Railway yang menyediakan container berbasis Linux dengan resource yang dapat diskalakan secara otomatis sesuai kebutuhan. Tidak diperlukan hardware khusus di sisi server karena seluruh infrastruktur dikelola oleh Railway.

**Spesifikasi Hardware (Client/Pengguna):**
Sistem dapat diakses menggunakan perangkat apa pun yang memiliki browser web modern (Chrome, Firefox, Edge, Safari) dengan koneksi internet, baik melalui komputer desktop, laptop, maupun perangkat mobile.
