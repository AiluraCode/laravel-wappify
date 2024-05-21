<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use AiluraCode\Wappify\Exceptions\PropertyNoExists;
use Exception;

class ImageMessage extends BaseMultimediaMessage
{
    /**
     * @param object $media
     *
     * @throws PropertyNoExists
     */
    public function __construct(object $media)
    {
        parent::__construct($media);
    }
}
