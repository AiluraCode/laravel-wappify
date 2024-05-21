<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities;

use AiluraCode\Wappify\Concern\IsEditable;
use AiluraCode\Wappify\Contracts\Messages\ShouldStatusChangeMessage;
use AiluraCode\Wappify\Enums\MessageStatusType;
use AiluraCode\Wappify\Exceptions\PropertyNoExists;
use Exception;

class ChangeStatusMessage extends BaseMessage implements ShouldStatusChangeMessage
{
    use IsEditable;

    public MessageStatusType $status;

    /**
     * @param object $message
     *
     * @throws PropertyNoExists
     */
    public function __construct(object $message)
    {
        $this->status = MessageStatusType::from($this->validateProperty($message, 'status'));
    }

    /**
     * Check if the message is read.
     *
     * @return bool
     */
    public function isRead(): bool
    {
        return MessageStatusType::READ === $this->status;
    }

    /**
     * Check if the message is sent.
     *
     * @return bool
     */
    public function isSent(): bool
    {
        return MessageStatusType::SENT === $this->status;
    }

    /**
     * Check if the message is delivered.
     *
     * @return bool
     */
    public function isDelivered(): bool
    {
        return MessageStatusType::DELIVERED === $this->status;
    }

    /**
     * Check if the message is waiting.
     *
     * @return bool
     */
    public function isWaiting(): bool
    {
        return MessageStatusType::WAITING === $this->status;
    }
}
