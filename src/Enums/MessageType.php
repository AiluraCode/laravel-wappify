<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Enums;

use Illuminate\Support\Facades\Config;

/**
 * @method static MessageType TEXT()
 * @method static MessageType IMAGE()
 * @method static MessageType AUDIO()
 * @method static MessageType DOCUMENT()
 * @method static MessageType VIDEO()
 * @method static MessageType LOCATION()
 * @method static MessageType CONTACT()
 * @method static MessageType STICKER()
 * @method static MessageType INTERACTIVE()
 * @method static MessageType CONTACTS()
 * @method static MessageType STATUS()
 */
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
    case TEMPLATE = 'template';

    public function isDownloadable(): bool
    {
        $haystack = Config::get('wappify.download.allowed');

        // @phpstan-ignore-next-line
        return in_array($this, $haystack, true);
    }
}
