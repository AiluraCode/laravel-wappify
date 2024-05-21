<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use Exception;

class AudioMessage extends BaseMessage
{
    public bool $voice;

    /**
     * @param object $media
     *
     * @throws Exception
     */
    public function __construct(private readonly object $media)
    {
        parent::__construct($this->media);
        $this->voice = boolval($this->validateProperty($this->media, 'voice'));
    }
}
