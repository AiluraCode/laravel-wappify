<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use AiluraCode\Wappify\Exceptions\PropertyNoExists;

class AudioMessage extends BaseMultimediaMessage
{
    private bool $voice;

    /**
     * @param object $media
     *
     * @throws PropertyNoExists
     */
    public function __construct(object $media)
    {
        parent::__construct($media);
        $this->voice = boolval($this->validateProperty($media, 'voice'));
    }

    public function isVoice(): bool
    {
        return $this->voice;
    }
}
