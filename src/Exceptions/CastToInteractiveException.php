<?php

namespace AiluraCode\Wappify\Exceptions;

class CastToTextException extends BaseException
{
    public function __construct(string $message = 'The message could not be cast to text.')
    {
        parent::__construct($message, ExceptionCode::CAST_TO_TEXT_EXCEPTION);
    }
}
