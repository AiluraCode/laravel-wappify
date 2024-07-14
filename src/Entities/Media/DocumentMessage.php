<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Entities\Media;

use AiluraCode\Wappify\Concern\IsEditable;
use AiluraCode\Wappify\Exceptions\PropertyNoExists;

class DocumentMessage extends BaseMultimediaMessage
{
    use IsEditable;

    private string $name;

    /**
     * @param object $media
     *
     * @throws PropertyNoExists
     */
    public function __construct(object $media)
    {
        parent::__construct($media);
        $this->name = $this->validateProperty($media, 'name');
    }

    /**
     * Get the name of the document.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
