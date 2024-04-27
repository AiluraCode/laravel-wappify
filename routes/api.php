<?php

use AiluraCode\Wappify\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::controller(WhatsappController::class)
    ->name('whatsapp.')
    ->prefix('whatsapp')
    ->group(
        function (): void {
            Route::post('/webhook', 'receive')->name('receive');
        }
    );
