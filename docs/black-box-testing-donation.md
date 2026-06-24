# Black Box Testing — Fitur Donasi Homepage

**URL:** `http://localhost:8000`  
**Trigger:** Klik tombol **"Donasi Langsung"** pada section Donasi  
**Metode:** Black Box Testing (input/output, tanpa lihat kode)  
**Tanggal:** 2026-06-24

---

## Komponen yang Diuji

- Modal form donasi
- Validasi field (nama, no. WA, email, jumlah, metode pembayaran)
- Preset jumlah donasi
- Pemilihan metode pembayaran
- Submit form → redirect ke halaman pembayaran Duitku

---

## Test Cases

### TC-01 — Modal Buka & Tutup

| # | Aksi | Ekspektasi |
|---|------|-----------|
| 1.1 | Klik "Donasi Langsung" | Modal muncul, scroll halaman terkunci |
| 1.2 | Klik ikon ✕ di pojok modal | Modal tertutup, scroll normal kembali |
| 1.3 | Klik area gelap di luar modal | Modal tertutup |
| 1.4 | Tekan tombol `Escape` di keyboard | Modal tertutup |

---

### TC-02 — Preset Jumlah Donasi

| # | Aksi | Ekspektasi |
|---|------|-----------|
| 2.1 | Klik preset "Rp 50.000" | Input jumlah terisi 50000, tombol preset aktif (hijau) |
| 2.2 | Klik preset "Rp 1.000.000" | Input jumlah terisi 1000000, tombol lain tidak aktif |
| 2.3 | Klik preset A lalu klik preset B | Hanya preset B yang aktif |
| 2.4 | Klik preset lalu ubah manual input | Nilai input mengikuti input manual |

---

### TC-03 — Validasi Field Wajib (Happy Negative)

| # | Kondisi Input | Ekspektasi |
|---|--------------|-----------|
| 3.1 | Semua field kosong, submit | Browser native validation: Nama wajib diisi |
| 3.2 | Nama diisi, WA kosong, submit | Browser native validation: No. WA wajib |
| 3.3 | Nama + WA diisi, Email kosong, submit | Browser native validation: Email wajib |
| 3.4 | Semua teks diisi, jumlah kosong, submit | Browser native validation: Jumlah wajib |
| 3.5 | Semua diisi, metode pembayaran tidak dipilih, submit | Pesan error merah muncul di bawah tombol metode: "Pilih metode pembayaran." |
| 3.6 | Jumlah diisi kurang dari 10.000, submit | Server mengembalikan error 422: jumlah minimum Rp 10.000 |
| 3.7 | Email format salah (misal: `abc@`), submit | Browser native validation: format email tidak valid |

---

### TC-04 — Pemilihan Metode Pembayaran

| # | Aksi | Ekspektasi |
|---|------|-----------|
| 4.1 | Klik "ShopeePay" | Tombol ShopeePay aktif (border hijau), hidden input `payment_method = SL` |
| 4.2 | Klik "Mandiri VA" | Tombol Mandiri VA aktif, hidden input `payment_method = BT` |
| 4.3 | Klik "QR / QRIS" | Tombol QR aktif, hidden input `payment_method = QR` |
| 4.4 | Klik metode A lalu klik metode B | Hanya B yang aktif, A kembali ke default |

---

### TC-05 — Submit Berhasil (Happy Path)

**Prasyarat:** Server berjalan, program aktif ada di DB, Duitku sandbox aktif

| # | Kondisi | Ekspektasi |
|---|---------|-----------|
| 5.1 | Semua field valid, metode = ShopeePay, klik submit | Tombol berubah "Memproses...", spinner muncul |
| 5.2 | (lanjutan 5.1) API Duitku response sukses | Browser redirect ke `payment_url` Duitku |
| 5.3 | (lanjutan 5.1) Data tersimpan di DB | Tabel `donors`, `donations`, `duitku_payments` memiliki record baru |
| 5.4 | Donor dengan email sama donasi ulang | Donor tidak duplikat, hanya `donations` record baru yang dibuat |

---

### TC-06 — Submit Gagal (Error Handling)

| # | Kondisi | Ekspektasi |
|---|---------|-----------|
| 6.1 | Tidak ada program aktif di DB | Error 422 muncul di modal: "Tidak ada program aktif saat ini." |
| 6.2 | Duitku API error / sandbox down | Error 500 muncul di modal: "Gagal memproses donasi. Silakan coba lagi." |
| 6.3 | Internet putus saat submit | Error muncul: "Koneksi gagal. Periksa internet Anda." |
| 6.4 | (setelah error) Tombol submit | Tombol kembali aktif, bisa submit ulang |

---

### TC-07 — Spinner & Loading State

| # | Aksi | Ekspektasi |
|---|------|-----------|
| 7.1 | Klik submit (request sedang berjalan) | Tombol disabled, text berubah "Memproses...", spinner animasi muncul |
| 7.2 | Request selesai (sukses/gagal) | Spinner hilang, tombol kembali enabled |
| 7.3 | Klik submit berulang kali cepat | Hanya 1 request yang berjalan (tombol disabled saat proses) |

---

### TC-08 — Aksesibilitas & UX

| # | Kondisi | Ekspektasi |
|---|---------|-----------|
| 8.1 | Buka modal di mobile (layar kecil) | Form scrollable, tidak overflow ke luar layar |
| 8.2 | Tab key navigasi form | Semua field dapat dicapai dengan keyboard |
| 8.3 | Buka modal, isi form, tutup, buka lagi | Form tidak reset (state tetap) — opsional, bisa juga di-reset sesuai kebutuhan |

---

## Hasil Testing

| TC | Status | Catatan |
|----|--------|---------|
| TC-01 | ⬜ Belum diuji | |
| TC-02 | ⬜ Belum diuji | |
| TC-03 | ⬜ Belum diuji | |
| TC-04 | ⬜ Belum diuji | |
| TC-05 | ⬜ Belum diuji | Perlu Duitku sandbox aktif |
| TC-06 | ⬜ Belum diuji | |
| TC-07 | ⬜ Belum diuji | |
| TC-08 | ⬜ Belum diuji | |

---

## Catatan Teknis

- **Metode pembayaran valid:** `SL` (ShopeePay), `BT` (Mandiri VA), `QR` (QRIS)
- **Minimum donasi:** Rp 10.000
- **Duplikasi donor:** Dicegah via `firstOrCreate` berdasarkan `email`
- **CSRF:** Dikirim via header `X-CSRF-TOKEN` dari FormData
- **Log:** Setiap donasi masuk tercatat di `storage/logs/laravel.log` — cek jika ada error tak terduga
