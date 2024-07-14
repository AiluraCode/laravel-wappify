<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use AiluraCode\Wappify\Concern\IsEditable;
use AiluraCode\Wappify\Exceptions\PropertyNoExists;

class StickerMessage extends BaseMultimediaMessage
{
    use IsEditable;

    private bool $animated;

    /**
     * @param object $media
     *
     * @throws PropertyNoExists
     */
    public function __construct(object $media)
    {
        parent::__construct($media);
        $this->animated = boolval($this->validateProperty($media, 'animated'));
    }

    public function isAnimated(): bool
    {
        return $this->animated;
    }
}
