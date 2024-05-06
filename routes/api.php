<?php

use AiluraCode\Wappify\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::controller(WhatsappController::class)
    ->name(config('wappify.api.name') . '.')
    ->prefix(config('wappify.api.prefix'))
    ->group(
        function (): void {
            Route::prefix('webhook')
                ->middleware(config('wappify.middlewares.webhook'))
                ->group(
                    function (): void {
                        Route::get('/', 'webhook')->name('webhook');
                        Route::post('/', 'receive')->name('receive');
                    }
                );

            Route::prefix('messages')
                ->middleware(config('wappify.middlewares.messages'))
                ->group(
                    function (): void {
                        Route::get('/', 'index')->name('messages.index');
                        Route::get('{id}', 'show')->name('messages.show');
                        Route::delete('{id}', 'destroy')->name('messages.destroy');
                        Route::group(
                            ['prefix' => '{id}/media'],
                            function (): void {
                                Route::get('/', 'media')->name('messages.media');
                                Route::get('/stream', 'stream')->name('messages.media.stream');
                                Route::get('/download', 'download')->name('messages.media.download');
                            }
                        );
                    }
                );

            Route::prefix('chat')
                ->middleware(config('wappify.middlewares.chat'))
                ->group(
                    function (): void {
                        Route::get('/{from}', 'chat')->name('chat');
                        Route::get('/{from}/me', 'me')->name('chat.me');
                        Route::get('/{from}/you', 'you')->name('chat.you');
                    }
                );
        }
    );
