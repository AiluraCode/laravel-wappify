<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use Exception;

class Video extends Base
{
    /**
     * @param object $media
     *
     * @throws Exception
     */
    public function __construct(private readonly object $media)
    {
        parent::__construct($this->media);
    }
}
