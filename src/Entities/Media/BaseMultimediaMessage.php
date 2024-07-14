<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use AiluraCode\Wappify\Concern\IsEditable;
use AiluraCode\Wappify\Concern\IsMultimediable;
use AiluraCode\Wappify\Contracts\Messages\ShouldMultimediaMessage;
use AiluraCode\Wappify\Entities\BaseMessage;
use AiluraCode\Wappify\Exceptions\PropertyNoExists;

abstract class BaseMultimediaMessage extends BaseMessage implements ShouldMultimediaMessage
{
    use IsMultimediable;
    use IsEditable;

    /**
     * @param object $media
     *
     * @throws PropertyNoExists
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
