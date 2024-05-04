<?php

use AiluraCode\Wappify\Enums\MessageType as Whatsapp;

return [
    'api' => [
        'url' => 'https://graph.facebook.com',
        'version' => 'v19.0',
        'token' => env('WHATSAPP_API_TOKEN'),
    ],

    'queue' => 'whatsapp',
    'tries' => 1,
    'timeout' => 60,
    'name' => 'wappify',

    'download' => [
        'automatic' => true,
        'strategy' => 'default',
        'allowed' => [
            Whatsapp::IMAGE,
            Whatsapp::AUDIO,
            Whatsapp::DOCUMENT,
            Whatsapp::VIDEO,
            Whatsapp::STICKER,
        ],
    ],

    'default' => [
        'disk' => 'public',
        'path' => 'public/wappify',
    ],

    'spatie' => [
        'disk' => 'public',
        'properties' => [],
    ]
];
