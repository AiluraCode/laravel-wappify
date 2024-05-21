<?php

namespace AiluraCode\Wappify\Entities;

use AiluraCode\Wappify\Concern\IsMessageable;
use AiluraCode\Wappify\Concern\IsValidable;
use AiluraCode\Wappify\Contracts\ShouldMessage;

/**
 * Class ShouldMessage.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
abstract class BaseMessage implements ShouldMessage
{
    use IsMessageable;
    use IsValidable;
}
