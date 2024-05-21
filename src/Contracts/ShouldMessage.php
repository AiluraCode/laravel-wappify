<?php

namespace AiluraCode\Wappify\Contracts;

use AiluraCode\Wappify\Enums\MessageType;
use Exception;

/**
 * Interface ShouldMessageable.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
interface ShouldMessageable
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
     * Get the profile name of the account that wrote the message.
     *
     * @return string
     */
    public function getProfile(): string;

    /**
     * Get the mobile number associated with the account that wrote the message.
     *
     * @return string
     */
    public function getFrom(): string;

    /**
     * Get the type of the message.
     *
     * @return MessageType
     */
    public function getType(): MessageType;

    /**
     * Get the content of the message.
     *
     * @return object
     */
    public function getMessage(): object;

    /**
     * Get the timestamp of the time the message was received.
     *
     * @return int
     */
    public function getTimestamp(): int;

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
     * @since 1.0.0
     *
     * @version 1.0.0
     *
     * @author SiddharthaGF <livesanty_@hotmail.com>
     */
    public function validateProperty(object $object, string $property): string;
}
