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
    public $message = null;
    public $media = null;

    public function catch(mixed $payload): Wappify
    {
        $model = self::payloadToModel($payload);
        $this->whatsapp = new Whatsapp();
        $this->whatsapp->wa_id = $model['id'];
        $this->whatsapp->from = $model['from'];
        $this->whatsapp->type = $model['type'];
        $this->whatsapp->timestamp = $model['timestamp'];
        if ($this->whatsapp->type == 'text') {
            $this->message = new WhatsappMessages();
            $this->message->text = $model['message']['text'];
            $this->message->whatsapp_id = $this->whatsapp->id;
        } else {
            $this->media = new WhatsappMedia();
            $this->media->id = $model['message']['id'] ?? null;
            $this->media->mime_type = $model['message']['mime_type'] ?? null;
            $this->media->sha256 = $model['message']['sha256'] ?? null;
            $this->media->data = $model['message']['data'];
            $this->media->whatsapp_id = $this->whatsapp->id;
        }
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

        $metadataFields = ['id', 'mime_type', 'sha256'];

        $data = [
            "id" => $message['id'],
            "from" => $message['from'],
            "type" => $message['type'],
            "timestamp" => $message['timestamp']
        ];

        $media = array_filter($message[$data['type']], fn ($key) => in_array($key, $metadataFields), ARRAY_FILTER_USE_KEY);

        $media['data'] = json_encode(array_filter($message[$data['type']], fn ($key) => !in_array($key, $metadataFields), ARRAY_FILTER_USE_KEY));

        $data['message'] = $media;

        return $data;
    }
}
