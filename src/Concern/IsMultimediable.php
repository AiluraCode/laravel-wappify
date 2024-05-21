<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Concern;

/**
 * Provides functions to manipulate a media resource.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 */
trait IsMultimediable
{
    /**
     * The unique identifier of the media resource.
     *
     * @var string
     */
    private string $id;

    /**
     * The sha256 value of the media content.
     *
     * @var string
     */
    private string $sha256;

    /**
     * The Mime Type of the media resource.
     *
     * @var string
     */
    private string $mimeType;

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
     * Set the unique identifier of the media resource.
     *
     * @param string $id
     *
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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
     * Set sha256 value of media content.
     *
     * @param string $sha256
     *
     * @return void
     */
    public function setSha256(string $sha256): void
    {
        $this->sha256 = $sha256;
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

    /**
     * Set the Mime Type of the media resource.
     *
     * @param string $mimeType
     *
     * @return void
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }
}
