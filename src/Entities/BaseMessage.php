<?php

namespace AiluraCode\Wappify\Entities;

use AiluraCode\Wappify\Contracts\BaseMessageInterface;
use AiluraCode\Wappify\Traits\IsMessageable;
use AiluraCode\Wappify\Traits\IsValidable;

/**
 * Class BaseMessageInterface.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
abstract class BaseMediaMessage implements BaseMessageInterface
{
    use IsMessageable;
    use IsValidable;
}
