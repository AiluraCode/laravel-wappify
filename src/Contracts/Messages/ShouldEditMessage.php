<?php

namespace AiluraCode\Wappify\Contracts\Messages;

/**
 * Interface ShouldEditMessage.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
interface ShouldEditMessage
{
    /**
     * Convert the content message to an array.
     *
     * @return array<string, mixed> The message as an array
     */
    public function toArray(): array;
}
