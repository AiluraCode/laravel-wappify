<?php

namespace AiluraCode\Wappify;

use AiluraCode\Wappify\Models\Whatsapp;

/**
 * Class Wappify
 *
 * @package AiluraCode\Wappify
 */
class Wappify
{

    /**
     * Wappify constructor.
     *
     * @param Whatsapp $whatsapp
     */
    public function __construct(
        private Whatsapp $whatsapp
    ) {
    }

    /**
     * @param mixed $payload
     * @return Wappify
     */
    public static function catch(mixed $payload): Wappify
    {
        $model = self::payloadToModel($payload);
        $whatsapp = new Whatsapp();
        $whatsapp->wa_id = $model['id'];
        $whatsapp->from = $model['from'];
        $whatsapp->type = $model['type'];
        $whatsapp->message = $model['message'];
        $whatsapp->timestamp = $model['timestamp'];
        $instance = new self($whatsapp);
        return $instance;
    }

    /**
     * @return Whatsapp
     */
    public function get()
    {
        return $this->whatsapp;
    }

    /**
     *  Convert payload to
     *
     * @param mixed $payload
     * @return array
     */
    public static function payloadToModel(mixed $payload): array
    {
        $json = json_decode($payload, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid payload');
        }
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
