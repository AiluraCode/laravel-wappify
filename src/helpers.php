<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

/**
 * Get the WhatsAppCloudApi instance.
 *
 * @return WhatsAppCloudApi
 */
function whatsapp(): WhatsAppCloudApi
{
    return new WhatsAppCloudApi([
        'from_phone_number_id' => Config::get('wappify.client.number_id'),
        'access_token'         => Config::get('wappify.client.token'),
    ]);
}
