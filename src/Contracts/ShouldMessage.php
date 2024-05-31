<?php

namespace AiluraCode\Wappify\Contracts;

use AiluraCode\Wappify\Contracts\Messages\ShouldEditMessage;
use AiluraCode\Wappify\Enums\MessageType;
use Exception;

/**
 * Interface ShouldMessage.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
interface ShouldMessage
{
    /**
     * Get the unique identifier of the message.
     *
     * @see https://developers.facebook.com/docs/whatsapp/cloud-api/reference/messages/#mensages
     *
     * @return string
     */
    public function getWamId(): string;

    /**
     * Set the unique identifier of the message.
     *
     * @param string $wamid
     *
     * @return void
     */
    public function setWamId(string $wamid): void;

    /**
     * Get the profile name of the account that wrote the message.
     *
     * @return string
     */
    public function getProfile(): string;

    /**
     * Set the profile name of the account that wrote the message.
     *
     * @param string $profile
     *
     * @return void
     */
    public function setProfile(string $profile): void;

    /**
     * Get the mobile number associated with the account that wrote the message.
     *
     * @return string
     */
    public function getFrom(): string;

    /**
     * Set the mobile number associated with the account that wrote the message.
     *
     * @param string $from
     *
     * @return void
     */
    public function setFrom(string $from): void;

    /**
     * Get the type of the message.
     *
     * @return MessageType
     */
    public function getType(): MessageType;

    /**
     * Set the type of the message.
     *
     * @param MessageType $type
     *
     * @return void
     */
    public function setType(MessageType $type): void;

    /**
     * Get the content of the message.
     *
     * @return object
     */
    public function getMessage(): object;

    /**
     * Set the content of the message.
     *
     * @param ShouldEditMessage $message
     *
     * @return void
     */
    public function setMessage(ShouldEditMessage $message): void;

    /**
     * Get the timestamp of the time the message was received.
     *
     * @return int
     */
    public function getTimestamp(): int;


    /**
     * Set the timestamp of the time the message was received.
     *
     * @param int $timestamp
     *
     * @return void
     */
    public function setTimestamp(int $timestamp): void;

    /**
     * Validate if exists a property in an object.
     *
     * @param object $object   Object to validate
     * @param string $property Property to validate
     *
     * @return string The property value
     *
     * @throws Exception If the property does not exist
     *
     * @author SiddharthaGF <livesanty_@hotmail.com>
     */
    public function validateProperty(object $object, string $property): string;
}
