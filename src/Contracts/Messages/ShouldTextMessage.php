<?php

namespace AiluraCode\Wappify\Contracts\Messages;

/**
 * Interface ShouldTextMessage.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
interface ShouldTextMessage extends ShouldEditMessage
{
    /**
     * Get the body of the text message.
     *
     * @return string The body of the text message
     */
    public function getBody(): string;

    /**
     * Set the body of the text message.
     *
     * @param string $body The body of the text message
     * @return void
     */
    public function setBody(string $body): void;
}
