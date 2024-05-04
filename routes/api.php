<?php

use AiluraCode\Wappify\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::controller(WhatsappController::class)
    ->name('whatsapp.')
    ->prefix('whatsapp')
    ->group(
        function (): void {
            Route::group(
                ['prefix' => 'webhook'],
                function (): void {
                    Route::get('/', 'webhook')->name('webhook');
                    Route::post('/', 'receive')->name('receive');
                }
            );
            Route::prefix('messages')
                ->group(
                    function (): void {
                        Route::get('/', 'index')->name('messages.index');
                        Route::get('{id}', 'show')->name('messages.show');
                        Route::delete('{id}', 'destroy')->name('messages.destroy');
                        Route::group(
                            ['prefix' => '{id}/media'],
                            function (): void {
                                Route::get('/', 'index')->name('messages.media.index');
                                Route::delete('/', 'destroy')->name('messages.media.destroy');
                            }
                        );
                    }
                );
            Route::prefix('media')
                ->group(
                    function (): void {
                        Route::get('/', 'index')->name('media.index');
                        Route::delete('{id}', 'destroy')->name('messages.destroy');
                    }
                );
        }
    );
