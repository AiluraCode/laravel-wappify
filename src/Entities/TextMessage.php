<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities;

use AiluraCode\Wappify\Concern\IsTexteable;
use AiluraCode\Wappify\Contracts\ShouldTextMessage;
use Exception;

class ShouldTextMessage extends BaseMessage implements ShouldTextMessage
{
    use IsTexteable;

    public string $body;

    /**
     * @param object $message
     *
     * @throws Exception
     */
    public function __construct(object $message)
    {
        $this->body = $this->validateProperty($message, 'body');
    }
}
