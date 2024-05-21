<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Concern;

use AiluraCode\Wappify\Contracts\Messages\ShouldEditMessage;
use AiluraCode\Wappify\Enums\MessageType;

/**
 * Provides functions to manipulate a Whatsapp message.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
trait IsMessageable
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
        // @phpstan-ignore-next-line
        return $this->wamid;
    }

    /**
     * Set the unique identifier of the message.
     *
     * @param string $wamid
     *
     * @return void
     */
    public function setWamId(string $wamid): void
    {
        // @phpstan-ignore-next-line
        $this->wamid = $wamid;
    }

    /**
     * Get the profile name of the account that wrote the message.
     *
     * @return string
     */
    public function getProfile(): string
    {
        // @phpstan-ignore-next-line
        return $this->profile;
    }

    /**
     * Set the profile name of the account that wrote the message.
     *
     * @param string $profile
     *
     * @return void
     */
    public function setProfile(string $profile): void
    {
        // @phpstan-ignore-next-line
        $this->profile = $profile;
    }

    /**
     * Get the mobile number associated with the account that wrote the message.
     *
     * @return string
     */
    public function getFrom(): string
    {
        // @phpstan-ignore-next-line
        return $this->from;
    }

    /**
     * Set the mobile number associated with the account that wrote the message.
     *
     * @param string $from
     *
     * @return void
     */
    public function setFrom(string $from): void
    {
        // @phpstan-ignore-next-line
        $this->from = $from;
    }

    /**
     * Get the type of the message.
     *
     * @return MessageType
     */
    public function getType(): MessageType
    {
        // @phpstan-ignore-next-line
        return $this->type;
    }

    /**
     * Set the type of the message.
     *
     * @param MessageType $type
     *
     * @return void
     */
    public function setType(MessageType $type): void
    {
        // @phpstan-ignore-next-line
        $this->type = $type;
    }

    /**
     * Get the content of the message.
     *
     * @return object
     */
    public function getMessage(): object
    {
        // @phpstan-ignore-next-line
        return $this->message;
    }

    /**
     * Set the content of the message.
     *
     * @param ShouldEditMessage $message
     *
     * @return void
     */
    public function setMessage(ShouldEditMessage $message): void
    {
        foreach ($message->toArray() as $key => $value) {
            // @phpstan-ignore-next-line
            $this->message->$key = $value;
        }
    }

    /**
     * Get the timestamp of the time the message was received.
     *
     * @return int
     */
    public function getTimestamp(): int
    {
        // @phpstan-ignore-next-line
        return $this->timestamp;
    }

    /**
     * Set the timestamp of the time the message was received.
     *
     * @param int $timestamp
     *
     * @return void
     */
    public function setTimestamp(int $timestamp): void
    {
        // @phpstan-ignore-next-line
        $this->timestamp = $timestamp;
    }
}
