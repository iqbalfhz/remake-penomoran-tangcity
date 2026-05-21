# Aplikasi Penomoran Surat — Tangcity Group

Sistem penomoran surat digital untuk Tangcity Group, dibangun dengan Laravel 12 + Filament v5.

---

## Tech Stack

| Komponen           | Versi | Keterangan             |
| ------------------ | ----- | ---------------------- |
| PHP                | ^8.2  | Bahasa pemrograman     |
| Laravel            | ^12.0 | Framework backend      |
| Filament           | ^5.6  | Admin panel UI         |
| Spatie Permission  | ^7.4  | Role & permission      |
| Spatie Activitylog | ^5.0  | Audit trail            |
| SQLite             | —     | Database (development) |

---

## Format Nomor Dokumen

```
031/IM-E/IT/V/2026
│   │  │  │  └─ Tahun (4 digit)
│   │  │  └──── Bulan (Romawi)
│   │  └─────── Kode Departemen
│   └────────── KodeSurat-KodePT
└────────────── Nomor urut (3 digit, 0-padded)
```

### Kode PT

| Kode di Nomor | Nama Perusahaan |
| ------------- | --------------- |
| E             | EFM             |
| S             | SSK             |
| P             | PAKAR           |
| F             | FIKA            |
| K             | KOPERASI        |

### Contoh Nomor

- `031/IM-E/IT/V/2026` → Internal Memo ke-31, EFM, Departemen IT, Mei 2026
- `001/SK-S/HR/I/2026` → Surat Keluar pertama, SSK, Departemen HR, Januari 2026

---

## Instalasi

### 1. Clone & Install Dependencies

```bash
git clone <repo-url>
cd remake-penomoran-tangcity
composer install
npm install
```

### 2. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="Aplikasi Penomoran"
APP_URL=http://remake-penomoran-tangcity.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=penomoran_tangcity
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed
```

### 4. Build Assets

```bash
npm run build
# atau untuk development:
npm run dev
```

### 5. Jalankan Server

```bash
php artisan serve
```

Akses panel di: `http://localhost:8000/admin`

---

## Akun Default

| Field    | Value              |
| -------- | ------------------ |
| Email    | admin@tangcity.com |
| Password | admin123           |
| Role     | super_admin        |

> **Penting:** Ganti password setelah login pertama!

---

## Struktur Database

```
users                 — Akun pengguna (dengan departemen_id & role)
departemen            — Master departemen (IT, HR, ACCT, dst.)
jenis_surat           — Master jenis dokumen (IM, SK, SPK, dst.)
perihal               — Master perihal/topik surat
nomor_urut            — Counter nomor per (jenis_surat × PT × tahun)
dokumen               — Record dokumen yang telah dibuat
dokumen_perihal       — Pivot: dokumen ↔ perihal (many-to-many)
permissions           — Spatie Permission tables
roles                 — Spatie Role tables
activity_log          — Audit trail (Spatie Activitylog)
```

---

## Roles & Hak Akses

| Role          | Hak Akses                                              |
| ------------- | ------------------------------------------------------ |
| `super_admin` | Full akses semua menu, bisa pilih departemen mana saja |
| `user`        | Hanya bisa buat dokumen untuk departemen sendiri       |

---

## Menu Navigasi

### Master Data

- **Departemen** — CRUD kode & nama departemen
- **Jenis Surat** — CRUD jenis dokumen dengan warna badge
- **Perihal** — CRUD daftar perihal/topik surat
- **User** — CRUD user dengan assignment role & departemen

### Penomoran Surat

- **Dokumen** — List + buat nomor surat baru (nomor otomatis)

---

## Cara Membuat Nomor Dokumen Baru

1. Login ke panel `/admin`
2. Klik menu **Penomoran Surat → Dokumen → + Baru**
3. Isi form:
    - **Jenis Surat** — pilih dari dropdown
    - **Perusahaan (PT)** — pilih radio EFM/SSK/PAKAR/FIKA/KOPERASI
    - **Departemen** — otomatis terisi (regular user); bisa diubah (super_admin)
    - **Tanggal Surat** — default hari ini
    - **Perihal** — checklist satu atau lebih perihal
    - **Keterangan** — opsional
4. Klik **Simpan**
5. Nomor dokumen otomatis di-generate dan tersimpan

---

## Reset Nomor Urut Tahunan

Nomor urut direset otomatis setiap **1 Januari pukul 00:00**.

Untuk menjalankan manual:

```bash
php artisan nomor:reset
# atau tanpa konfirmasi:
php artisan nomor:reset --force
```

Aktifkan scheduler di server (tambahkan ke crontab):

```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## Struktur File Penting

```
app/
├── Console/Commands/
│   └── ResetNomorUrut.php       — Command reset tahunan
├── Filament/
│   ├── Resources/
│   │   ├── Departemens/         — Resource CRUD Departemen
│   │   ├── JenisSurats/         — Resource CRUD Jenis Surat
│   │   ├── Perihals/            — Resource CRUD Perihal
│   │   ├── Users/               — Resource CRUD User
│   │   └── Dokumens/            — Resource utama penomoran
│   └── Widgets/
│       └── StatsOverview.php    — Dashboard statistik
├── Models/
│   ├── Departemen.php
│   ├── Dokumen.php              — generateNomor() method
│   ├── JenisSurat.php
│   ├── NomorUrut.php            — getNextNomor() method
│   ├── Perihal.php
│   └── User.php
└── Providers/Filament/
    └── AdminPanelProvider.php   — Konfigurasi panel Filament

database/
├── migrations/                  — Semua tabel schema
└── seeders/
    ├── DatabaseSeeder.php
    ├── RoleSeeder.php           — Roles: super_admin, user
    ├── DepartemenSeeder.php     — 13 departemen awal
    ├── JenisSuratSeeder.php     — 8 jenis surat
    ├── PerihalSeeder.php        — 20 perihal umum
    └── AdminUserSeeder.php      — User admin default

routes/
└── console.php                  — Scheduler (reset tahunan)
```

---

## Development

### Reset database (mulai dari awal)

```bash
php artisan migrate:fresh --seed
```

### Tambah Jenis Surat Baru

1. Login sebagai super_admin
2. Master Data → Jenis Surat → + Baru
3. Isi kode (maks 10 karakter), nama, dan warna badge

### Tambah Departemen Baru

1. Master Data → Departemen → + Baru
2. Isi kode (maks 10 karakter) dan nama departemen

### Tambah User Baru

1. Master Data → User → + Baru
2. Isi nama, username, email, password, departemen, dan role

---

## Kustomisasi Lanjutan

### Perihal per Jenis Surat

Saat ini semua perihal berlaku untuk semua jenis surat (`jenis_surat_id = NULL`).
Untuk membatasi perihal hanya untuk jenis surat tertentu:

1. Edit perihal yang ingin dibatasi
2. Pilih **Jenis Surat** di field "Jenis Surat (Opsional)"

### Export Data

Package `pxlrbt/filament-excel` sudah di-install. Untuk mengaktifkan export di tabel dokumen,
tambahkan `ExportAction` di `DokumensTable.php`.

---

## Troubleshooting

### Nomor sudah terpakai (unique constraint)

Ini terjadi jika ada concurrent request. `NomorUrut::getNextNomor()` menggunakan `increment()`
yang atomic, sehingga aman untuk concurrent access dalam single server.
Untuk multi-server, gunakan database-level locking atau Redis.

### Login tidak bisa masuk

- Pastikan sudah menjalankan `php artisan db:seed`
- Pastikan password benar: `admin123`
- Cek apakah user memiliki role: `php artisan tinker` → `App\Models\User::first()->roles`

---

_Dibuat sebagai bagian dari WPU Course Project_
