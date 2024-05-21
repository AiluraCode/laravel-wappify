<?php

namespace AiluraCode\Wappify;

use AiluraCode\Wappify\Enums\MessageStatusType;
use AiluraCode\Wappify\Models\Whatsapp;
use Exception;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Netflie\WhatsAppCloudApi\Response;

class Wappify
{
    /**
     * Wappify constructor.
     *
     * @param Whatsapp $whatsapp
     */
    public function __construct(
        private readonly Whatsapp $whatsapp
    ) {
    }

    /**
     * @param string $payload
     *
     * @return Wappify
     *
     * @throws Exception
     */
    public static function catch(string $payload): Wappify
    {
        $data = self::payloadToModel($payload);

        return self::createFromModel($data);
    }

    /**
     * @param Response $response
     *
     * @return Wappify
     */
    public static function raise(Response $response): Wappify
    {
        $data = self::responseToModel($response);

        return self::createFromModel($data);
    }

    /**
     * Build the model from the response.
     *
     * @param Response $response the response from the WhatsApp API
     *
     * @return array<object> the data to create the model
     */
    public static function responseToModel(Response $response): array
    {
        // @phpstan-ignore-next-line
        $whatsappRequest = $response->request()->body();
        $whatsappBody = $response->decodedBody();
        $message = $whatsappRequest[$whatsappRequest['type']];
        $message['status'] = MessageStatusType::WAITING->value;

        return [
            'wamid'     => $whatsappBody['messages'][0]['id'],
            'profile'   => Config::get('wappify.profile'),
            'from'      => $whatsappBody['contacts'][0]['wa_id'],
            'type'      => $whatsappRequest['type'],
            'message'   => $message,
            'timestamp' => time(),
        ];
    }

    /**
     * Create a new instance of the model.
     *
     * @param array<object> $data
     *
     * @return Wappify
     */
    public static function createFromModel(array $data): Wappify
    {
        $whatsapp = new Whatsapp([
            'wamid'     => $data['wamid'],
            'profile'   => $data['profile'],
            'from'      => $data['from'],
            'type'      => $data['type'],
            'message'   => $data['message'],
            'timestamp' => $data['timestamp'],
        ]);

        return new Wappify($whatsapp);
    }

    /**
     * Get a Whatsapp model.
     *
     * @return Whatsapp
     */
    public function get(): Whatsapp
    {
        return $this->whatsapp;
    }

    /**
     * Build the model from the payload.
     *
     * @return array<object>
     *
     * @throws Exception
     */
    public static function payloadToModel(string $payload): array
    {
        $json = (object) json_decode($payload, false);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException('Invalid payload');
        }
        $value = $json->entry[0]->changes[0]->value;
        $message = $value->messages[0] ?? null;
        $status = $value->statuses[0] ?? null;

        if (!$message && !$status) {
            throw new Exception('Invalid payload');
        }

        if ($message) {
            $data = [
                'wamid'     => $message->id,
                'profile'   => $value->contacts[0]->profile->name,
                'from'      => $message->from,
                'type'      => $message->type,
                'message'   => $message->{$message->type},
                'timestamp' => $message->timestamp,
            ];
        } else {
            $data = [
                'wamid'     => $status->id,
                'profile'   => $value->metadata->display_phone_number,
                'from'      => $status->recipient_id,
                'type'      => 'status',
                'message'   => ['status' => $status->status],
                'timestamp' => $status->timestamp,
            ];
        }

        return $data;
    }
}
