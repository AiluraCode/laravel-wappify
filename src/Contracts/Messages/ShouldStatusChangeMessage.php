<?php

namespace AiluraCode\Wappify\Contracts\Messages;

/**
 * Interface TextMessageMessage.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
interface ShouldStatusChangeMessage extends ShouldEditMessage
{
    /**
     * Check if the message is read.
     *
     * @return bool
     */
    public function isRead(): bool;

    /**
     * Check if the message is sent.
     *
     * @return bool
     */
    public function isSent(): bool;

    /**
     * Check if the message is delivered.
     *
     * @return bool
     */
    public function isDelivered(): bool;

    /**
     * Check if the message is waiting.
     *
     * @return bool
     */
    public function isWaiting(): bool;
}
