<?php

namespace AiluraCode\Wappify\Enums\Exceptions;

/**
 * @phpstan-type const string
 */
enum ExceptionMessages: string
{
    case BASE_EXCEPTION = 'An error occurred.';
    case CAST_TO_TEXT_EXCEPTION = 'The message could not be cast to text.';
    case CAST_TO_INTERACTIVE_EXCEPTION = 'The message could not be cast to interactive.';
    case CAST_TO_IMAGE_EXCEPTION = 'The message could not be cast to image.';
    case CAST_TO_MEDIA_EXCEPTION = 'The message could not be cast to media.';
    case PROPERTY_NO_EXISTS_EXCEPTION = 'The property "%property%" does not exist in the object "%object%".';
}
