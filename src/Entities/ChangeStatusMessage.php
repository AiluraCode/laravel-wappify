<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities;

use AiluraCode\Wappify\Enums\MessageStatusType;
use Exception;

class ChangeStatusMessage extends BaseMessage
{
    public MessageStatusType $status;

    /**
     * @param object $message
     *
     * @throws Exception
     */
    public function __construct(object $message)
    {
        $this->status = MessageStatusType::from($this->validateProperty($message, 'status'));
    }

    public function isRead(): bool
    {
        return MessageStatusType::READ === $this->status;
    }

    public function isSent(): bool
    {
        return MessageStatusType::SENT === $this->status;
    }

    public function isDelivered(): bool
    {
        return MessageStatusType::DELIVERED === $this->status;
    }
}
