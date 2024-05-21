<?php

namespace AiluraCode\Wappify\Enums;

/**
 * @phpstan-type const positive-int
 */
enum ExceptionCode: int
{
    case BASE_EXCEPTION = 500;
    case CAST_TO_TEXT_EXCEPTION = 501;
    case CAST_TO_INTERACTIVE_EXCEPTION = 502;
}
