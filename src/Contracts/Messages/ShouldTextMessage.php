<?php

namespace AiluraCode\Wappify\Contracts;

/**
 * Interface TextMessageMessage.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
interface ShouldTextMessage extends ShouldMessage
{
    /**
     * Get the body of the text message.
     *
     * @return string The body of the text message
     */
    public function getBody(): string;
}
