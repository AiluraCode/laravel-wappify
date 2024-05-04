<?php

namespace AiluraCode\Wappify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class WappifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware('api')->prefix('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
        $this->publishes([
            __DIR__ . '/../config/wappify.php' => config_path('wappify.php'),
        ], 'wappify-config');

        if (empty(glob(database_path('migrations/*_create_wappify_tables.php')))) {
            $this->publishes([
                __DIR__ . '/../database/migrations/_create_wappify_tables.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_wappify_tables.php'),
            ], 'migrations');
        }
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\WappifyRunQueue::class,
            ]);
        }
    }
}
