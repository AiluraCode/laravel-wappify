<?php

namespace AiluraCode\Wappify\Exceptions;

use AiluraCode\Wappify\Enums\Exceptions\ExceptionCodes;
use AiluraCode\Wappify\Enums\Exceptions\ExceptionMessages;
use Exception;

class CastToMediaException extends Exception
{
    /**
     * @param ExceptionMessages $message
     * @param ExceptionCodes    $code
     */
    public function __construct(
        ExceptionMessages $message = ExceptionMessages::CAST_TO_MEDIA_EXCEPTION,
        ExceptionCodes $code = ExceptionCodes::CAST_TO_MEDIA_EXCEPTION
    ) {
        parent::__construct($message->value, $code->value);
    }
}
