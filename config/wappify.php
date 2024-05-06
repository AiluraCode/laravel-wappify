<?php

use AiluraCode\Wappify\Enums\MessageType as Whatsapp;

return [

    'client' => [
        'url' => 'https://graph.facebook.com',
        'version' => 'v19.0',
        'token' => env('WHATSAPP_API_TOKEN'),
    ],

    'api' => [
        'name' => 'whatsapp',
        'prefix' => 'whatsapp',
    ],

    'queue' => [
        'name' => 'whatsapp',
        'tries' => 1,
        'timeout' => 60,
        'name' => 'wappify',
    ],

    'profile' => 'wappify',

    'middlewares' => [
        'webhook' => [
            'facebook'
        ],
        'messages' => [
            'auth'
        ],
        'chat' => [],
    ],

    'middleware' => [
        'facebook' => [
            'name' => 'facebook',
            'headers' => [
                'User-Agent' => ['facebookplatform/1.0 (+http://developers.facebook.com)', 'facebookexternalua'],

            ],
            'unauthorized-request' => 'Request rejected because the client does not belong to Facebook',
        ],
        'auth' => [
            'name' => 'auth',
            'unauthorized-request' => 'Request rejected because the user is not authorized',
        ],
    ],

    'download' => [
        'automatic' => true,
        'strategy' => 'spatie',
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
        'collection' => 'whatsapp',
    ]
];
