<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Enums;

/**
 * @method static MessageStatusType READ()
 * @method static MessageStatusType SENT()
 * @method static MessageStatusType DELIVERED()
 */
enum MessageStatusType: string
{
    case READ = 'read';
    case SENT = 'sent';
    case DELIVERED = 'delivered';
    case WAITING = 'waiting';
}
