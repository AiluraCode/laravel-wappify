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
    case CONTACTS = 'contacts';
    case STATUS = 'status';

    public function isDownloadable(): bool
    {
        return in_array($this, config('wappify.download.allowed'));
    }
}
