<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Concern;

trait Multimediable
{
    /**
     * Get the unique identifier of the media resource.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get sha256 value of media content.
     *
     * @return string
     */
    public function getSha256(): string
    {
        return $this->sha256;
    }

    /**
     * Get the Mime Type of the media resource.
     *
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }
}
