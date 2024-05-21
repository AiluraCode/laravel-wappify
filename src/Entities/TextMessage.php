<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities;

use AiluraCode\Wappify\Concern\IsEditable;
use AiluraCode\Wappify\Concern\IsTexteable;
use AiluraCode\Wappify\Contracts\Messages\ShouldTextMessage;
use AiluraCode\Wappify\Exceptions\PropertyNoExists;
use Exception;

class TextMessage extends BaseMessage implements ShouldTextMessage
{
    use IsTexteable;
    use IsEditable;

    public string $body;

    /**
     * @param object $message
     *
     * @throws PropertyNoExists
     */
    public function __construct(object $message)
    {
        $this->body = $this->validateProperty($message, 'body');
    }
}
