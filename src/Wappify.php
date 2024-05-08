<?php

namespace AiluraCode\Wappify;

use AiluraCode\Wappify\Models\Whatsapp;
use Netflie\WhatsAppCloudApi\Response;

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
        return self::createFromModel($model);
    }

    /**
     * @param Response $response
     * @return Wappify
     */
    public static function raise(Response $response): Wappify
    {
        $model = self::responseToModel($response);
        return self::createFromModel($model);
    }

    /**
     * @param Response $response
     * @return array
     */
    public static function responseToModel(Response $response): array
    {
        $whatsappRequest = $response->request()->body();
        $whatsappBody = $response->decodedBody();
        $data = [
            "wamid" => $whatsappBody['messages'][0]['id'],
            "profile" => config('wappify.profile'),
            "from" => $whatsappBody['contacts'][0]['wa_id'],
            "type" => $whatsappRequest['type'],
            "message" => $whatsappRequest[$whatsappRequest['type']],
            "timestamp" => time(),
        ];
        return $data;
    }

    /**
     * @param array $model
     * @return Wappify
     */
    public static function createFromModel(array $model): Wappify
    {
        $whatsapp = new Whatsapp();

        $whatsapp->wamid = $model['wamid'];
        $whatsapp->profile = $model['profile'];
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
        $status = $json['entry'][0]['changes'][0]['value']['statuses'][0] ?? null;
        if (!$message && !$status) {
            throw new \Exception('Invalid payload');
        }
        if ($message) {
            $data = [
                "wamid" => $message['id'],
                "profile" => $json['entry'][0]['changes'][0]['value']['contacts'][0]['profile']['name'],
                "from" => $message['from'],
                "type" => $message['type'],
                "message" => $message[$message['type']],
                "timestamp" => $message['timestamp'],
            ];
        } else {
            $data = [
                'wamid' => $status['id'],
                'profile' => $json['entry'][0]['changes'][0]['value']['metadata']['display_phone_number'],
                'from' => $status['recipient_id'],
                "type" => 'status',
                'message' => ["status" => $status['status']],
                'timestamp' => $status['timestamp'],
            ];
        }
        return $data;
    }
}
