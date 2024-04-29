<?php

use AiluraCode\Wappify\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::controller(WhatsappController::class)
    ->name('whatsapp.')
    ->prefix('whatsapp')
    ->group(
        function (): void {
            Route::post('/webhook', 'receive')->name('receive');
            Route::get('/', 'index')->name('index');
            Route::get('/history/{from}', 'history')->name('history');
            Route::get('/media/{id}', 'media')->name('media');
            Route::get('/media/{id}/download', 'download')->name('download');
            Route::get('/media/{id}/stream', 'stream')->name('stream');
        }
    );
