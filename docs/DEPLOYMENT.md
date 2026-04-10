# Hostinger Shared Hosting Deployment Guide

## სტრუქტურა Hostinger-ზე
```
/home/user/
├── public_html/          ← Laravel-ის public/ შიგთავსი
│   ├── index.php
│   ├── .htaccess
│   ├── build/
│   └── storage -> ../archvadze/storage/app/public
└── archvadze/            ← Laravel-ის root (public_html-ის გარეთ)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    └── .env
```

## ნაბიჯები

### 1. GitHub-დან clone
```bash
cd /home/user/
git clone https://github.com/arttrade/archvadze.com.git archvadze
```

### 2. public_html გასუფთავება და კოპირება
```bash
# public_html-ის გასუფთავება
rm -rf ~/public_html/*
rm -rf ~/public_html/.*

# public/ შიგთავსის კოპირება public_html-ში
cp -r ~/archvadze/public/. ~/public_html/
```

### 3. index.php-ში paths განახლება
```bash
nano ~/public_html/index.php
```
შეცვალე:
```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```
→
```php
require __DIR__.'/../archvadze/vendor/autoload.php';
$app = require_once __DIR__.'/../archvadze/bootstrap/app.php';
```

### 4. .env შექმნა
```bash
cp ~/archvadze/.env.production.example ~/archvadze/.env
nano ~/archvadze/.env
```
შეავსე:
- APP_KEY (php artisan key:generate --show)
- DB_DATABASE, DB_USERNAME, DB_PASSWORD
- PAYPAL credentials

### 5. Storage symlink
```bash
cd ~/archvadze
php artisan storage:link --relative
```
ან manually:
```bash
ln -s ~/archvadze/storage/app/public ~/public_html/storage
```

### 6. Permissions
```bash
chmod -R 755 ~/archvadze/storage
chmod -R 755 ~/archvadze/bootstrap/cache
```

### 7. Composer install
```bash
cd ~/archvadze
composer install --no-dev --optimize-autoloader
```

### 8. Database migrate
```bash
php artisan migrate --force
```

### 9. Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 10. Admin user შექმნა
```bash
php artisan tinker
$user = App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@archvadze.com',
    'password' => bcrypt('YOUR_STRONG_PASSWORD'),
    'email_verified_at' => now(),
]);
$user->assignRole('Super Admin');
```

## Hostinger-ში MySQL DB შექმნა
1. hPanel → Databases → MySQL Databases
2. Create Database
3. Create User
4. Add User to Database (All Privileges)

## SSL
hPanel → SSL → Install SSL Certificate (უფასოა Let's Encrypt)

## PHP Version
hPanel → Advanced → PHP Configuration → PHP 8.3

## შემოწმება
- https://archvadze.com — საიტი
- https://archvadze.com/admin — ადმინი
- https://archvadze.com/sitemap.xml — Sitemap
