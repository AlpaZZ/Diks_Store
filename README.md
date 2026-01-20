# 🎮 DIKS STORE - Marketplace Jual Beli Akun & Top Up Game

**Diks Store** adalah aplikasi web marketplace untuk jual beli akun game dan top up game, dibangun menggunakan Laravel 11.


## 📋 Fitur Utama

### 🛒 User
- Registrasi & Login
- Jual beli akun game
- Top up game (Diamond, UC, dll)
- Upload bukti pembayaran
- Riwayat transaksi
- Profile management

### 👨‍💼 Admin
- Dashboard dengan statistik
- Manajemen produk & kategori
- Manajemen pesanan (akun & top up)
- Manajemen pengguna
- Export laporan (PDF & Excel)

---

## 🛠️ Persyaratan Sistem

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 5.7 atau **MariaDB** >= 10.3
- **Node.js** >= 18 (untuk compile assets, opsional)
- **NPM** >= 9 (opsional)

---

## 🚀 Cara Instalasi

### Langkah 1: Extract dan Buka Terminal

```bash
cd Diks_Store
```

### Langkah 2: Install Dependencies PHP

```bash
composer install
```

### Langkah 3: Copy File Environment

```bash
# Windows (Command Prompt)
copy .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env

# Linux/Mac
cp .env.example .env
```

### Langkah 4: Generate Application Key

```bash
php artisan key:generate
```

### Langkah 5: Konfigurasi Database

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=diks_store
DB_USERNAME=root
DB_PASSWORD=
```

> **Catatan:** Buat database `diks_store` terlebih dahulu di MySQL/phpMyAdmin

### Langkah 6: Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan:
- Membuat semua tabel yang diperlukan
- Mengisi data sample (admin, kategori, produk, top up)

### Langkah 7: Buat Storage Link

```bash
php artisan storage:link
```

### Langkah 8: Install Dependencies Frontend (Opsional)

```bash
npm install
npm run build
```

### Langkah 9: Jalankan Server

```bash
php artisan serve
```

Aplikasi berjalan di: **http://localhost:8000**

---

## 🔐 Akun Default

### Admin
| Email | Password |
|-------|----------|
| raziq@diksstore.com | admin123 |
| alfarizki@diksstore.com | admin123 |
| yowan@diksstore.com | admin123 |
| dimas@diksstore.com | admin123 |

### User (Sample)
| Email | Password |
|-------|----------|
| user@example.com | user123 |

---

## 📁 Struktur Folder Penting

```
Diks_Store/
├── app/
│   ├── Http/Controllers/     # Controller aplikasi
│   └── Models/               # Model Eloquent
├── database/
│   ├── migrations/           # File migrasi database
│   └── seeders/              # Data seeder
├── resources/views/          # Blade templates
├── routes/web.php            # Definisi routes
├── public/                   # Assets publik
└── storage/                  # File uploads
```

---

## 🗄️ Struktur Database

| Tabel | Deskripsi |
|-------|-----------|
| users | Data pengguna (admin & user) |
| categories | Kategori game |
| products | Akun game yang dijual |
| orders | Pesanan jual beli akun |
| topups | Paket top up game |
| topup_orders | Pesanan top up game |

---

## ⚙️ Troubleshooting

### Error: "Could not find driver"
Pastikan extension MySQL di PHP sudah aktif:
```ini
; php.ini
extension=pdo_mysql
extension=mysqli
```

### Error: "SQLSTATE[HY000] [1049] Unknown database"
Buat database terlebih dahulu:
```sql
CREATE DATABASE diks_store;
```

### Error: "The symlink function is disabled"
Jalankan Command Prompt/Terminal sebagai **Administrator**, lalu:
```bash
php artisan storage:link
```

### Images tidak muncul
Pastikan sudah menjalankan `php artisan storage:link`

---

## 📝 Catatan Tambahan

1. Aplikasi menggunakan **Laravel 11** dengan PHP 8.2+
2. Template menggunakan **Bootstrap 5** dengan custom styling
3. Export PDF menggunakan **barryvdh/laravel-dompdf**
4. Export Excel menggunakan format CSV (kompatibel dengan Microsoft Excel)

---

**© 2026 Diks Store - All Rights Reserved**
