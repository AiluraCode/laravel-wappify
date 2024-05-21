<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Concern;

use AiluraCode\Wappify\Enums\MessageType;

trait Messageable
{
    /**
     * Get the unique identifier of the message.
     *
     * @see https://developers.facebook.com/docs/whatsapp/cloud-api/reference/messages/#mensages
     *
     * @return string
     */
    public function getWamId(): string
    {
        return $this->wamid;
    }

    /**
     * Get the profile name of the account that wrote the message.
     *
     * @return string
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * Get the mobile number associated with the account that wrote the message.
     *
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Get the type of the message.
     *
     * @return MessageType
     */
    public function getType(): MessageType
    {
        return $this->type;
    }

    /**
     * Get the content of the message.
     *
     * @return object
     */
    public function getMessage(): object
    {
        return $this->message;
    }

    /**
     * Get the timestamp of the time the message was received.
     *
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}
