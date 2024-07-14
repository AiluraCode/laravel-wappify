<?php

return [
    'client' => [
        'url'     => 'https://graph.facebook.com',
        'version' => 'v19.0',
    ],

    'accounts' => [
        'default' => [
            'profile'   => 'default',
            'number_id' => env('WHATSAPP_API_PHONE_NUMBER_ID'),
            'token'     => env('WHATSAPP_API_TOKEN'),
            'queue'     => [
                'connection' => 'redis',
                'name'       => 'wappify',
                'tries'      => 3,
                'timeout'    => 5,
            ],
            'download' => [
                'automatic' => true,
                'strategy'  => 'spatie',
                'allowed'   => [
                    AiluraCode\Wappify\Enums\MessageType::IMAGE,
                    AiluraCode\Wappify\Enums\MessageType::AUDIO,
                    AiluraCode\Wappify\Enums\MessageType::DOCUMENT,
                    AiluraCode\Wappify\Enums\MessageType::VIDEO,
                    AiluraCode\Wappify\Enums\MessageType::STICKER,
                ],
            ],
        ],
    ],

    'api' => [
        'prefix'   => 'api',
        'path'     => 'whatsapp',
        'name'     => 'wappify',
        'webhooks' => [
            AiluraCode\Wappify\Http\Controllers\WebhookController::class,
        ],
        'middleware_webhooks' => [
            'facebook',
        ],
        'resources' => [
            AiluraCode\Wappify\Http\Controllers\MessagesController::class,
            AiluraCode\Wappify\Http\Controllers\ChatController::class,
        ],
        'middleware_resources' => [
            // 'auth',
        ],
    ],

    'middleware' => [
        'facebook' => [
            'name'    => 'facebook',
            'headers' => [
                'User-Agent' => ['facebookplatform/1.0 (+http://developers.facebook.com)', 'facebookexternalua'],
            ],
        ],
        'auth' => [
            'name'                 => 'auth',
            'unauthorized-request' => 'Request rejected because the user is not authorized',
        ],
    ],

    'local' => [
        'disk' => 'public',
        'path' => 'public/wappify',
    ],

    'spatie' => [
        'disk'       => 'public',
        'properties' => [],
        'collection' => 'whatsapp',
    ],
];
