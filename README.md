# 🔐 SIPANDIK

**Sistem Informasi Pelaporan Persandian dan Statistik**

![Laravel](https://img.shields.io/badge/Laravel-12. x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)

SIPANDIK adalah platform terintegrasi untuk pelaporan kerentanan/bug pada aplikasi dan permintaan data statistik di lingkungan Pemerintah Provinsi Lampung.

---

## ✨ Fitur Utama

### 🐛 Pelaporan Bug & Kerentanan
- Sistem tiket untuk pelaporan bug/kerentanan aplikasi
- Kategorisasi berdasarkan jenis kerentanan (XSS, SQL Injection, CSRF, dll)
- Tingkat keparahan (severity level)
- Upload bukti/screenshot
- Sistem apresiasi untuk pelapor

### 📊 Permintaan Data Statistik
- Formulir permintaan data statistik
- Upload dokumen pendukung
- Status tracking permintaan
- Download hasil data yang diminta

### 👤 Portal User
- Dashboard personal
- Riwayat laporan bug
- Riwayat permintaan data
- Status tracking real-time

### ⚙️ Panel Admin
- Dashboard statistik keseluruhan
- Manajemen laporan bug (review, update status, apresiasi)
- Manajemen permintaan data
- CRUD OPD (Organisasi Perangkat Daerah)
- CRUD Aplikasi
- CRUD Jenis Kerentanan
- Export laporan ke Excel/PDF

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel 12.x, PHP 8.2+ |
| **Frontend** | Blade, TailwindCSS, Alpine.js |
| **Build Tool** | Vite |
| **Database** | MySQL / SQLite |
| **Export** | Maatwebsite Excel, DomPDF |
| **Testing** | Pest PHP |

---

## 📦 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL atau SQLite

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/bugsm/sipandik.git
   cd sipandik
   ```

2. **Jalankan script setup** (metode cepat)
   ```bash
   composer setup
   ```

   **Atau secara manual:**
   ```bash
   # Install dependencies
   composer install
   npm install

   # Setup environment
   cp .env.example .env
   php artisan key:generate

   # Konfigurasi database di file .env
   # Lalu jalankan migrasi
   php artisan migrate

   # (Opsional) Seed data dummy
   php artisan db:seed

   # Build assets
   npm run build
   ```

3. **Jalankan development server**
   ```bash
   composer dev
   ```
   
   Atau secara terpisah:
   ```bash
   php artisan serve        # Server Laravel
   npm run dev              # Vite dev server
   php artisan queue: listen # Queue worker
   ```

4. **Akses aplikasi**
   ```
   http://localhost:8000
   ```

---

## 🔑 Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sipandik.local | password |
| User | user@sipandik.local | password |

> ⚠️ **Penting**: Ganti password default sebelum deploy ke production!

---

## 📁 Struktur Direktori

```
sipandik/
├── app/
│   ├── Exports/          # Export Excel (Bug Reports, Data Requests)
│   ├── Http/Controllers/
│   │   ├── Admin/        # Controller panel admin
│   │   └── User/         # Controller portal user
│   └── Models/           # Eloquent models
├── database/
│   ├── factories/        # Model factories
│   ├── migrations/       # Database migrations
│   └── seeders/          # Data seeders
├── resources/
│   ├── views/
│   │   ├── admin/        # Views panel admin
│   │   ├── user/         # Views portal user
│   │   └── components/   # Blade components
│   ├── css/              # Stylesheets
│   └── js/               # JavaScript
├── routes/
│   ├── web.php           # Web routes
│   └── auth.php          # Authentication routes
└── tests/                # Test suites
```

---

## 🧪 Testing

```bash
# Jalankan semua test
composer test

# Atau dengan Pest langsung
php artisan test

# Test dengan coverage
php artisan test --coverage
```

---

## 📋 API Routes Summary

### User Routes (`/user`)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/user/dashboard` | Dashboard user |
| GET | `/user/bug-reports` | List laporan bug |
| POST | `/user/bug-reports` | Submit laporan bug |
| GET | `/user/data-requests` | List permintaan data |
| POST | `/user/data-requests` | Submit permintaan data |

### Admin Routes (`/admin`)
| Method | URI | Deskripsi |
|--------|-----|-----------|
| GET | `/admin/dashboard` | Dashboard admin |
| GET | `/admin/bug-reports` | Manajemen laporan bug |
| GET | `/admin/bug-reports/export/{format}` | Export laporan |
| PATCH | `/admin/bug-reports/{id}/status` | Update status |
| GET | `/admin/data-requests` | Manajemen permintaan data |
| RESOURCE | `/admin/opd` | CRUD OPD |
| RESOURCE | `/admin/applications` | CRUD Aplikasi |
| RESOURCE | `/admin/vulnerability-types` | CRUD Jenis Kerentanan |

---

## 🗃️ Model Relasi

```
User
 ├── hasMany → BugReport
 └── hasMany → DataRequest

OPD (Organisasi Perangkat Daerah)
 └── hasMany → Application

Application
 ├── belongsTo → OPD
 └── hasMany → BugReport

VulnerabilityType
 └── hasMany → BugReport

BugReport
 ├── belongsTo → User
 ├── belongsTo → Application
 └── belongsTo → VulnerabilityType

DataRequest
 └── belongsTo → User
```

---

## 🚀 Deployment

### Production Build
```bash
npm run build
php artisan config:cache
php artisan route: cache
php artisan view:cache
php artisan optimize
```

### Environment Variables
Pastikan mengkonfigurasi `.env` untuk production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sipandik.yourdomain.go.id

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=sipandik
DB_USERNAME=your-username
DB_PASSWORD=your-secure-password
```

---

## 🤝 Kontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

---

## 📄 Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

---

## 📞 Kontak

**Dinas Komunikasi, Informatika, dan Statistik Provinsi Lampung**

- Website: [https://diskominfotik.lampungprov.go.id](https://diskominfotik.lampungprov.go.id)
- Email: diskominfotik@lampungprov.go.id

---

<p align="center">
  <sub>Built with ❤️ for Pemerintah Provinsi Lampung</sub>
</p>
