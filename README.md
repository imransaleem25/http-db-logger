# Http DB Logger

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imransaleem/http-db-logger.svg)](https://packagist.org/packages/imransaleem/http-db-logger)
[![License](https://img.shields.io/packagist/l/imransaleem/http-db-logger.svg)](LICENSE)

A Laravel middleware package to log all incoming HTTP requests into the database.

**Requirements:** PHP 8.3+ · Laravel 10, 11, or 12

---

## Installation

You can install the package via Composer:

```bash
composer require imransaleem/http-db-logger
```

## Configuration (Optional)

If you're not using Laravel package auto-discovery, add the service provider manually in `config/app.php`:

```php
'providers' => [
    // Other service providers...
    Imransaleem\HttpDbLogger\HttpDbLoggerServiceProvider::class,
],
```

## Register Middleware

### Laravel 10

Add the middleware in `app/Http/Kernel.php`:

```php
protected $middleware = [
    // Other middleware...
    \Imransaleem\HttpDbLogger\Middleware\LogHttpToDatabase::class,
];
```

### Laravel 11 / 12

Register the middleware in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\Imransaleem\HttpDbLogger\Middleware\LogHttpToDatabase::class);
})
```

## Publish Configuration & Migration

To publish the config and migration files, run:

```bash
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=migrations
```

Then run the migration:

```bash
php artisan migrate
```

## Example Usage

You can apply the middleware to a specific route group like this:

```php
use Imransaleem\HttpDbLogger\Middleware\LogHttpToDatabase;

Route::middleware(['auth', LogHttpToDatabase::class])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
```

## Configuration Options

You can customize the logger via `config/http-db-logger.php`:

- `log_requests` — enable/disable request logging (default: `true`)
- `log_api_response` — store API response bodies (default: `true`)
- `log_web_response` — store web response bodies (default: `false`)
- `table` — logging table name (default: `http_db_logs`)

## Database Table

The package creates a `http_db_logs` table with the following fields:

- `id`
- `method`
- `url`
- `request_type`
- `request_body` (nullable)
- `response_status` (nullable)
- `response_body` (nullable)
- `ip_address` (nullable)
- `created_by` (nullable)
- `user_role` (nullable)
- `created_at` / `updated_at`

---

© 2025 [Imran Saleem](https://github.com/imransaleem) — Licensed under MIT
