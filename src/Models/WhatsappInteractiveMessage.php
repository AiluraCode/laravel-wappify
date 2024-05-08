<?php

namespace AiluraCode\Wappify\Models;

class WhatsappInteractiveMessage
{
    public string $type;
    private object $button_reply;

    public function __construct(object $message)
    {
        $this->type = $message->type;
        $this->button_reply = $message->button_reply;
    }

    /**
     * Check if the interactive message is a button
     *
     * @return boolean
     */
    public function isButtonReply(): bool
    {
        return $this->type === 'button_reply';
    }

    /**
     * Get the button reply id
     *
     * @return string
     */
    public function getButtonReplyId(): string
    {
        return $this->button_reply->id;
    }

    /**
     * Get the button reply title
     *
     * @return string
     */
    public function getButtonReplyTitle(): string
    {
        return $this->button_reply->title;
    }
}
