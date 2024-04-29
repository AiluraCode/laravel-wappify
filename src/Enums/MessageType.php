<?php

namespace AiluraCode\Wappify\Enums;

enum MessageType: string
{
    case TEXT = 'text';
    case IMAGE = 'image';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case VIDEO = 'video';
    case LOCATION = 'location';
    case CONTACT = 'contact';
    case STICKER = 'sticker';
    case INTERACTIVE = 'interactive';

    public function isDownloadable(): bool
    {
        return in_array($this, [
            self::IMAGE,
            self::AUDIO,
            self::DOCUMENT,
            self::VIDEO,
            self::STICKER,
        ]);
    }
}
