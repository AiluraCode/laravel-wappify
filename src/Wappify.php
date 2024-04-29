<?php

namespace AiluraCode\Wappify;

use AiluraCode\Wappify\Models\Whatsapp;
use AiluraCode\Wappify\Models\WhatsappMedia;
use AiluraCode\Wappify\Models\WhatsappMessages;

/**
 * Class Wappify
 *
 * @property Whatsapp $whatsapp
 * @property WhatsappMessages $message
 * @property WhatsappMedia $media
 * @package AiluraCode\Wappify
 */
class Wappify
{
    public $whatsapp = null;

    public function catch(mixed $payload): Wappify
    {
        $model = self::payloadToModel($payload);
        $this->whatsapp = new Whatsapp();
        $this->whatsapp->wa_id = $model['id'];
        $this->whatsapp->from = $model['from'];
        $this->whatsapp->type = $model['type'];
        $this->whatsapp->message = $model['message'];
        $this->whatsapp->timestamp = $model['timestamp'];
        return $this;
    }

    public function save(): Wappify
    {
        $this->whatsapp->save();
        if ($this->whatsapp->type == 'text') {
            $this->message->save();
        } else {
            $this->media->save();
        }
        return $this;
    }

    public static function payloadToModel(mixed $payload)
    {
        $json = json_decode($payload, true);

        $message = $json['entry'][0]['changes'][0]['value']['messages'][0] ?? null;

        if (!$message) {
            throw new \Exception('Invalid payload');
        }

        $data = [
            "id" => $message['id'],
            "from" => $message['from'],
            "type" => $message['type'],
            "message" => $message[$message['type']],
            "timestamp" => $message['timestamp'],
        ];

        return $data;
    }
}
