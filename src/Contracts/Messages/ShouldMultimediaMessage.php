<?php

namespace AiluraCode\Wappify\Contracts\Messages;

/**
 * Interface Media.
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 *
 * @version 1.0.0
 */
interface ShouldMultimediaMessage extends ShouldEditMessage
{
    /**
     * Get the unique identifier of the media resource.
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getId(): string;

    /**
     * Set the unique identifier of the media resource.
     *
     * @param string $id
     *
     * @return void
     */
    public function setId(string $id): void;

    /**
     * Get sha256 value of media content.
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getSha256(): string;

    /**
     * Set sha256 value of media content.
     *
     * @param string $sha256
     *
     * @return void
     */
    public function setSha256(string $sha256): void;

    /**
     * Get the Mime Type of the media resource.
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getMimeType(): string;

    /**
     * Set the Mime Type of the media resource.
     *
     * @param string $mimeType
     *
     * @return void
     */
    public function setMimeType(string $mimeType): void;
}
