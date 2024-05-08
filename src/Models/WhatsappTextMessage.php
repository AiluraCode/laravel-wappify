<?php

namespace AiluraCode\Wappify\Models;

class WhatsappTextMessage
{
    public string $body;

    public function __construct(Whatsapp $whatsapp)
    {
        $this->body = $whatsapp->message->body;
    }
}
