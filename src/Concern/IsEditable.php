<?php

namespace AiluraCode\Wappify\Concern;

/**
 * Provides functions to edit a Whatsapp message.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
trait IsEditable
{
    /**
     * Convert the content message to an array.
     *
     * @return array<string, mixed> The message as an array
     */
    public function toArray(): array
    {
        $array = [];
        // @phpstan-ignore-next-line
        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }
}
