# 🚀 Deployment Guide - Buku Tamu ke VPS

## 📋 Persiapan Sebelum Deploy

### 1. Kebutuhan Server VPS

- PHP 5.3+ (recommended: PHP 7.4 atau 8.0+)
- MySQL/MariaDB 5.5+
- Apache dengan mod_rewrite enabled
- Akses SSH ke VPS

### 2. Extensions PHP yang Diperlukan

```bash
php-mysqli
php-mbstring
php-json
php-session
php-openssl
```

## 🔧 Langkah-Langkah Deployment

### Step 1: Upload Files ke VPS

```bash
# Via Git (Recommended)
cd /var/www/html/
git clone https://github.com/your-repo/bukutamu.git
cd bukutamu

# Atau via FTP/SCP
# Upload semua file kecuali: .git/, node_modules/, *.md, error_log
```

### Step 2: Setup Environment File

```bash
# Copy dan edit .env file
cp .env.example .env
nano .env

# Set permission yang aman
chmod 600 .env
```

**Isi .env dengan credentials VPS:**

```env
APP_ENV=production
DB_HOST=localhost
DB_USER=your_db_user
DB_PASS=your_strong_password
DB_NAME=simc8935_bukutamu
# ... dst
```

### Step 3: Setup Database

```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE simc8935_bukutamu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE simc8935_skm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE simc8935_perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Buat user database
CREATE USER 'bukutamu_user'@'localhost' IDENTIFIED BY 'strong_password_here';

# Grant privileges
GRANT ALL PRIVILEGES ON simc8935_bukutamu.* TO 'bukutamu_user'@'localhost';
GRANT ALL PRIVILEGES ON simc8935_skm.* TO 'bukutamu_user'@'localhost';
GRANT ALL PRIVILEGES ON simc8935_perpustakaan.* TO 'bukutamu_user'@'localhost';
FLUSH PRIVILEGES;

# Import database schema
mysql -u bukutamu_user -p simc8935_bukutamu < database_backup.sql
```

### Step 4: Set Permissions

```bash
# Set ownership
chown -R www-data:www-data /var/www/html/bukutamu

# Set folder permissions
find /var/www/html/bukutamu -type d -exec chmod 755 {} \;

# Set file permissions
find /var/www/html/bukutamu -type f -exec chmod 644 {} \;

# Special permissions
chmod 600 .env
chmod 644 .htaccess
chmod 644 config/.htaccess
chmod 644 includes/.htaccess
chmod 644 admin/.htaccess
```

### Step 5: Apache Configuration

**Buat VirtualHost `/etc/apache2/sites-available/bukutamu.conf`:**

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/html/bukutamu

    <Directory /var/www/html/bukutamu>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/bukutamu_error.log
    CustomLog ${APACHE_LOG_DIR}/bukutamu_access.log combined
</VirtualHost>
```

**Enable site dan restart Apache:**

```bash
a2ensite bukutamu.conf
a2enmod rewrite
systemctl restart apache2
```

### Step 6: Setup SSL (Recommended)

```bash
# Install Certbot
apt install certbot python3-certbot-apache

# Generate SSL Certificate
certbot --apache -d yourdomain.com -d www.yourdomain.com

# Auto-renewal test
certbot renew --dry-run
```

## 🔒 Security Checklist

- [ ] File `.env` dengan permission 600
- [ ] APP_ENV=production di .env
- [ ] Password database kuat (min 16 karakter)
- [ ] SSL/HTTPS aktif
- [ ] File `.htaccess` berfungsi (test akses ke `/config/config.php` harus 403)
- [ ] Error logs tidak tampil ke user
- [ ] Backup database secara berkala
- [ ] Update PHP dan dependencies secara rutin

## 🧪 Testing Setelah Deploy

1. **Test Home Page**

   ```
   https://yourdomain.com/
   ```

2. **Test Admin Login**

   ```
   https://yourdomain.com/admin/
   ```

3. **Test Protected Folders** (harus 403 Forbidden)

   ```
   https://yourdomain.com/config/config.php
   https://yourdomain.com/includes/security.php
   https://yourdomain.com/.env
   ```

4. **Test CSRF Protection**

   - Coba submit form tanpa token → harus ditolak

5. **Test Database Connection**
   - Login admin
   - Coba tambah/hapus data

## 🔄 Update/Maintenance

### Pull Update dari Git

```bash
cd /var/www/html/bukutamu
git pull origin main

# Backup dulu sebelum update
cp .env .env.backup
```

### Backup Database

```bash
# Manual backup
mysqldump -u bukutamu_user -p simc8935_bukutamu > backup_$(date +%Y%m%d).sql

# Setup cronjob untuk auto backup (setiap hari jam 2 pagi)
0 2 * * * /usr/bin/mysqldump -u bukutamu_user -p'password' simc8935_bukutamu > /backups/bukutamu_$(date +\%Y\%m\%d).sql
```

### Monitor Error Logs

```bash
# Cek error logs
tail -f /var/www/html/bukutamu/error_log

# Cek Apache error logs
tail -f /var/log/apache2/bukutamu_error.log
```

## ⚠️ Troubleshooting

### Problem: 500 Internal Server Error

- Cek permission file/folder
- Cek .htaccess syntax
- Cek PHP error log
- Pastikan mod_rewrite enabled

### Problem: Database Connection Failed

- Cek credentials di .env
- Cek MySQL service: `systemctl status mysql`
- Cek user privileges: `SHOW GRANTS FOR 'bukutamu_user'@'localhost';`

### Problem: CSRF Token Invalid

- Clear browser cache
- Pastikan session berfungsi
- Cek permission folder session: `ls -la /var/lib/php/sessions`

### Problem: CSS/JS Not Loading

- Cek path di browser console
- Pastikan folder `vendor/`, `css/`, `js/` ter-upload
- Cek permission: `chmod 644 vendor/css/*`

## 📞 Support

Jika ada masalah saat deployment:

1. Cek error_log di folder aplikasi
2. Cek Apache error log
3. Cek PHP error log
4. Dokumentasi lengkap ada di dokumentasi teknis

---

**Last Updated:** December 2025  
**PHP Version:** 5.3+ Compatible  
**Tested on:** Ubuntu 20.04/22.04, CentOS 7/8
