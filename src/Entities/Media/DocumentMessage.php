<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use Exception;

class Document extends Base
{
    public string $name;

    /**
     * @param object $media
     *
     * @throws Exception
     */
    public function __construct(private readonly object $media)
    {
        parent::__construct($this->media);
        $this->name = $this->validateProperty($this->media, 'name');
    }
}
