<?php

namespace Imransaleem\HttpDbLogger;

use Illuminate\Support\ServiceProvider;

class HttpDbLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/http-db-logger.php' => config_path('http-db-logger.php'),
        ], 'config');

        if (!class_exists('CreateHttpLogsTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_http_logs_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_http_logs_table.php'),
            ], 'migrations');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/http-db-logger.php',
            'http-db-logger'
        );
    }
}

