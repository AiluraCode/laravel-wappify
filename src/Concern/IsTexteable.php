<?php

namespace AiluraCode\Wappify\Concern;

/**
 * Provides functions to manipulate a Whatsapp text message.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
trait IsTexteable
{
    /**
     * Get the body of the text message.
     *
     * @return string The body of the text message
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Set the body of the text message.
     *
     * @param string $body The body of the text message
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }
}
