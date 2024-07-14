<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use AiluraCode\Wappify\Exceptions\PropertyNoExists;

class VideoMessage extends BaseMultimediaMessage
{
    /**
     * @param object $media
     *
     * @throws PropertyNoExists
     *
     * @since 1.0.0
     */
    public function __construct(object $media)
    {
        parent::__construct($media);
    }
}
