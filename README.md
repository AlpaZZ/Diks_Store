# 🎮 DIKS STORE - Marketplace Jual Beli Akun & Top Up Game

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

**Diks Store** adalah aplikasi web marketplace untuk jual beli akun game dan top up game, dibangun menggunakan Laravel 11. Aplikasi ini cocok untuk memulai bisnis jual beli akun game atau layanan top up diamond/UC secara online.

---

### Halaman Utama
- Homepage dengan katalog game
- Detail game dengan paket top up & akun tersedia
- Sistem pembayaran dengan upload bukti transfer

### Dashboard User
- Riwayat pesanan (akun & top up) dalam satu halaman
- Profile management
- Status tracking pesanan real-time

### Dashboard Admin
- Statistik penjualan & pendapatan
- Manajemen produk, kategori, dan paket top up
- Manajemen pesanan dengan update status
- Manajemen pengguna dengan fitur ban/unban
- Export laporan PDF & Excel

---

## 📋 Fitur Utama

### 🛒 Fitur User
| Fitur | Deskripsi |
|-------|-----------|
| 🔐 Registrasi & Login | Sistem autentikasi lengkap |
| 🎮 Katalog Game | Lihat semua game yang tersedia |
| 💎 Top Up Game | Beli diamond, UC, dan item game lainnya |
| 🛍️ Beli Akun | Marketplace akun game premium |
| 💳 Upload Bukti Bayar | Konfirmasi pembayaran via transfer |
| 📜 Riwayat Transaksi | Lacak semua pesanan dalam satu halaman |
| 👤 Profil | Kelola data diri dan password |

### 👨‍💼 Fitur Admin
| Fitur | Deskripsi |
|-------|-----------|
| 📊 Dashboard | Statistik penjualan, pendapatan, dan grafik |
| 📦 Manajemen Produk | CRUD akun game yang dijual |
| 🏷️ Manajemen Kategori | Kelola kategori/game |
| 💎 Manajemen Top Up | Atur paket top up per game |
| 📋 Manajemen Pesanan | Proses pesanan akun & top up |
| 👥 Manajemen User | Lihat, ban/unban pengguna |
| 📄 Export Laporan | Download PDF & Excel |

---

## 🛠️ Persyaratan Sistem

| Software | Versi Minimum | Rekomendasi |
|----------|---------------|-------------|
| PHP | 8.2 | 8.3 |
| Composer | 2.0 | Latest |
| MySQL | 5.7 | 8.0 |
| Node.js | 18 (opsional) | 20 LTS |
| NPM | 9 (opsional) | 10 |

### Extensions PHP yang Diperlukan
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML
- GD / Imagick (untuk gambar)
```

---

## 🚀 Cara Instalasi

### Metode 1: Clone dari Repository

```bash
# Clone repository
git clone https://github.com/username/diks-store.git
cd diks-store
```

### Metode 2: Download ZIP

1. Download dan extract file ZIP
2. Buka terminal di folder project

```bash
cd Diks_Store
```

### Langkah Instalasi

#### 1️⃣ Install Dependencies PHP

```bash
composer install
```

#### 2️⃣ Copy File Environment

```bash
# Windows (Command Prompt)
copy .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env

# Linux/Mac
cp .env.example .env
```

#### 3️⃣ Generate Application Key

```bash
php artisan key:generate
```

#### 4️⃣ Konfigurasi Database

Buat database baru di MySQL:

```sql
CREATE DATABASE diks_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Buka file `.env` dan sesuaikan konfigurasi:

```env
APP_NAME="Diks Store"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=diks_store
DB_USERNAME=root
DB_PASSWORD=
```

#### 5️⃣ Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan:
- ✅ Membuat semua tabel yang diperlukan
- ✅ Mengisi data admin default
- ✅ Mengisi data kategori game sample
- ✅ Mengisi data produk & top up sample

#### 6️⃣ Buat Storage Link

```bash
# Windows: Jalankan sebagai Administrator
php artisan storage:link
```

#### 7️⃣ Install Dependencies Frontend (Opsional)

```bash
npm install
npm run build
```

#### 8️⃣ Jalankan Server Development

```bash
php artisan serve
```

🎉 **Aplikasi berjalan di:** http://localhost:8000

---

## 🔐 Akun Default

### 👨‍💼 Admin
| Email | Password | Role |
|-------|----------|------|
| raziq@diksstore.com | admin123 | Admin |
| alfarizki@diksstore.com | admin123 | Admin |
| yowan@diksstore.com | admin123 | Admin |
| dimas@diksstore.com | admin123 | Admin |

### 👤 User Sample
| Email | Password | Role |
|-------|----------|------|
| user@example.com | user123 | User |

> ⚠️ **Penting:** Ganti password default setelah instalasi untuk keamanan!

---

## 📁 Struktur Folder

```
Diks_Store/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controller aplikasi
│   │   └── Middleware/       # Middleware (auth, admin, banned)
│   ├── Models/               # Model Eloquent
│   └── Providers/            # Service providers
├── bootstrap/                # Bootstrap aplikasi
├── config/                   # File konfigurasi
├── database/
│   ├── migrations/           # File migrasi database
│   └── seeders/              # Data seeder
├── public/                   # Assets publik (entry point)
├── resources/
│   ├── css/                  # Stylesheet
│   ├── js/                   # JavaScript
│   └── views/                # Blade templates
│       ├── admin/            # Views admin
│       ├── auth/             # Views login/register
│       ├── exports/          # Views PDF export
│       ├── game/             # Views katalog game
│       ├── layouts/          # Layout templates
│       ├── topup/            # Views top up
│       └── user/             # Views user dashboard
├── routes/
│   └── web.php               # Definisi routes
├── storage/                  # File uploads & cache
├── .env.example              # Template environment
├── composer.json             # Dependencies PHP
└── package.json              # Dependencies Node.js
```

---

## 🗄️ Struktur Database

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Data pengguna (admin & user), termasuk status banned |
| `categories` | Kategori/game (Mobile Legends, Free Fire, dll) |
| `products` | Akun game yang dijual |
| `orders` | Pesanan jual beli akun |
| `topups` | Paket top up game (diamond, UC, dll) |
| `topup_orders` | Pesanan top up game |

### Relasi Database
```
users ─────┬───── orders ───── products ───── categories
           │
           └───── topup_orders ───── topups ───── categories
```

---

## ⚙️ Konfigurasi Tambahan

### Mengubah Nama Aplikasi
Edit file `.env`:
```env
APP_NAME="Nama Toko Anda"
```

### Mengubah Timezone
Edit file `config/app.php`:
```php
'timezone' => 'Asia/Jakarta',
```

### Mengubah Nomor WhatsApp Admin
Cari dan ganti nomor di file views:
- `resources/views/topup/payment.blade.php`
- `resources/views/user/orders/detail.blade.php`

---

## ⚙️ Troubleshooting

### ❌ Error: "Could not find driver"
**Solusi:** Aktifkan extension MySQL di PHP

```ini
; Buka php.ini dan uncomment:
extension=pdo_mysql
extension=mysqli
```

### ❌ Error: "SQLSTATE[HY000] [1049] Unknown database"
**Solusi:** Buat database terlebih dahulu

```sql
CREATE DATABASE diks_store;
```

### ❌ Error: "The symlink function is disabled"
**Solusi:** Jalankan terminal sebagai **Administrator**

```bash
php artisan storage:link
```

### ❌ Error: "Too many redirects"
**Solusi:** Hapus cookies browser atau buka di mode incognito

### ❌ Gambar tidak muncul
**Solusi:** Pastikan sudah menjalankan:
```bash
php artisan storage:link
```

### ❌ Error: "Class not found"
**Solusi:** Regenerate autoload
```bash
composer dump-autoload
```

---

## 🚀 Deployment ke Production

### 1. Optimasi untuk Production
```bash
# Optimasi autoload
composer install --optimize-autoloader --no-dev

# Cache config & routes
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Setting Environment
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
```

### 3. Keamanan
- Ganti semua password default
- Set `APP_DEBUG=false`
- Gunakan HTTPS
- Backup database secara berkala

---

## 📝 Teknologi yang Digunakan

| Teknologi | Fungsi |
|-----------|--------|
| **Laravel 11** | Framework PHP backend |
| **Bootstrap 5** | Framework CSS frontend |
| **MySQL** | Database |
| **Blade** | Template engine |
| **barryvdh/laravel-dompdf** | Export PDF |
| **Bootstrap Icons** | Icon library |

---

## 🤝 Kontribusi

Kontribusi selalu diterima! Silakan:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/fitur-baru`)
3. Commit perubahan (`git commit -m 'Menambah fitur baru'`)
4. Push ke branch (`git push origin feature/fitur-baru`)
5. Buat Pull Request

---

## 📄 Lisensi

Project ini dibuat untuk keperluan **edukasi** dan dapat digunakan secara bebas.

---

## 👨‍💻 Developer

Dibuat dengan ❤️ oleh **Tim Diks Store**

- Raziq
- Alfarizki  
- Yowan
- Dimas

---

## 📞 Kontak & Support

Jika ada pertanyaan atau butuh bantuan:
- Buat issue di repository ini
- Hubungi developer via email

---

**© 2026 Diks Store - All Rights Reserved**
