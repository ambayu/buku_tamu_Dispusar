# Buku Tamu - Dinas Perpustakaan dan Kearsipan Kota Medan

Aplikasi Buku Tamu dan Survei Kepuasan Masyarakat dengan keamanan tingkat tinggi.

## ✨ Fitur

- 📝 Buku tamu digital
- 📊 Survei Kepuasan Masyarakat (SKM)
- 📚 Pemesanan buku perpustakaan
- 🔒 Sistem keamanan lengkap (CSRF, XSS, SQL Injection protection)
- 👨‍💼 Panel admin dengan dashboard

## 🛠️ Teknologi

- **PHP**: 5.3+ compatible (tested on PHP 8.3)
- **Database**: MySQL/MariaDB dengan prepared statements
- **Security**: CSRF tokens, bcrypt password hashing, session security
- **Frontend**: Bootstrap, jQuery, DataTables, SweetAlert2

## 📁 Struktur Folder

```
bukutamu/
├── admin/          # Panel admin dan file management
├── config/         # Konfigurasi database dan koneksi
├── includes/       # Library security dan polyfills
├── pages/          # Halaman-halaman utama aplikasi
├── css/           # Stylesheet
├── js/            # JavaScript files
├── img/           # Images
├── vendor/        # Third-party libraries
├── .env           # Environment variables (tidak di-commit)
└── index.php      # Homepage publik
```

## 🚀 Quick Start

### Development

```bash
# Clone repository
git clone <repo-url>
cd bukutamu

# Setup environment
cp .env.example .env
# Edit .env dengan database credentials

# Import database
mysql -u root -p < database.sql

# Jalankan development server
php -S localhost:8000
```

## 🔒 Security Features

✅ **SQL Injection Protection**: Prepared statements dengan parameter binding  
✅ **CSRF Protection**: Token validation di semua forms  
✅ **XSS Prevention**: Output sanitization dan escaping  
✅ **Session Security**: Secure cookies, regeneration, timeout  
✅ **Password Hashing**: Bcrypt dengan cost factor 12  
✅ **Rate Limiting**: Login attempt throttling  
✅ **Input Validation**: Comprehensive validation functions

## 🔧 Requirements

- PHP 5.3+ (PHP 7.4+ recommended)
- MySQL 5.5+ atau MariaDB
- Apache dengan mod_rewrite
- PHP Extensions: mysqli, mbstring, json, session, openssl

## 👥 Admin Access

Default admin credentials (ganti setelah first login):

- URL: `/admin/`
- Username: admin
- Password: (set saat instalasi)
