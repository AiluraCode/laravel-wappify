<?php

use Illuminate\Support\Facades\Route;

Route::name(config('wappify.api.name') . '.')
    // @phpstan-ignore-next-line
    ->prefix(config('wappify.api.path', 'wappify'))
    ->middleware(config('wappify.api.middleware_resources'))
    ->group(
        function (): void {
            foreach (config('wappify.api.resources') as $class) {
                add_route($class);
            }
        }
    );

Route::name(config('wappify.api.name') . '.')
    // @phpstan-ignore-next-line
    ->prefix(config('wappify.api.path', 'wappify'))
    ->middleware(config('wappify.api.middleware_webhooks'))
    ->group(
        function (): void {
            foreach (config('wappify.api.webhooks') as $class) {
                add_route($class);
            }
        }
    );
