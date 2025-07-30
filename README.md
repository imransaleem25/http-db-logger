# Http DB Logger

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imransaleem/http-db-logger.svg)](https://packagist.org/packages/imransaleem/date-formator)
[![License](https://img.shields.io/packagist/l/imransaleem/http-db-logger.svg)](LICENSE)

A Laravel middleware package to log all incoming HTTP requests into the database.

---

## 📦 Installation

You can install the package via Composer:
```bash
composer require imransaleem/http-db-logger
```

## 🔧 Configuration (Optional)

If you're not using Laravel package auto-discovery, add the service provider manually in `config/app.php`:

```php
'providers' => [
    // Other service providers...
    Imransaleem\HttpDbLogger\HttpDbLoggerServiceProvider::class,
],
```

## 🛡 Register Middleware

Add the middleware in `app/Http/Kernel.php`:

```php
protected $middleware = [
    // Other middleware...
    \Imransaleem\HttpDbLogger\Middleware\LogHttpToDatabase::class,
];
```

## 🚀 Publish Configuration & Migration

To publish the config and migration files, run:

```bash
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=migrations
```

Then run the migration:

```bash
php artisan migrate
```

## ⚙️ Configuration Options

You can customize the logger via `config/http-db-logger.php`. Options include:
- `log_requests`: boolean default true,
- `log_authenticated_user`: Log user ID and role if authenticated.
- `table`: logging table for database

## 🗃 Database Table

The package creates a `http_db_logs` table with the following fields:
- `id`
- `method`
- `uri`
- `ip`
- `headers`
- `body`
- `created_by` (nullable)
- `user_role` (nullable)
- `created_at` / `updated_at`

---

© 2025 [Imran Saleem](https://github.com/imransaleem) — Licensed under MIT
