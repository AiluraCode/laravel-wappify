<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use AiluraCode\Wappify\Concern\IsEditable;
use AiluraCode\Wappify\Concern\IsMultimediable;
use AiluraCode\Wappify\Contracts\Messages\ShouldMediaMessage;
use AiluraCode\Wappify\Entities\BaseMessage;
use Exception;

abstract class BaseMediaMessage extends BaseMessage implements ShouldMediaMessage
{
    use IsMultimediable;
    use IsEditable;

    /**
     * @param object $media
     *
     * @throws Exception
     *
     * @since 1.0.0
     */
    public function __construct(object $media)
    {
        $this->id = $this->validateProperty($media, 'id');
        $this->sha256 = $this->validateProperty($media, 'sha256');
        $this->mimeType = $this->validateProperty($media, 'mime_type');
    }
}
