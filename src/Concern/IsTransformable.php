<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Concern;

use AiluraCode\Wappify\Contracts\Messages\ShouldMultimediaMessage;
use AiluraCode\Wappify\Contracts\Messages\ShouldTextMessage;
use AiluraCode\Wappify\Entities\ChangeStatusMessage;
use AiluraCode\Wappify\Entities\Interactive\InteractiveMessage;
use AiluraCode\Wappify\Entities\Media\AudioMessage;
use AiluraCode\Wappify\Entities\Media\DocumentMessage;
use AiluraCode\Wappify\Entities\Media\ImageMessage;
use AiluraCode\Wappify\Entities\Media\StickerMessage;
use AiluraCode\Wappify\Entities\Media\VideoMessage;
use AiluraCode\Wappify\Entities\TextMessage;
use AiluraCode\Wappify\Enums\MessageType;
use AiluraCode\Wappify\Exceptions\CastToInteractiveException;
use AiluraCode\Wappify\Exceptions\CastToMediaException;
use AiluraCode\Wappify\Exceptions\CastToTextException;
use AiluraCode\Wappify\Exceptions\PropertyNoExists;
use Exception;

/**
 * Provides functions to transform a Whatsapp message.
 *
 * @since 1.0.0
 *
 * @version 1.0.0
 *
 * @author SiddharthaGF <livesanty_@hotmail.com>
 * /
 */
trait IsTransformable
{
    /**
     * Check if the message is an interactive message.
     *
     * @return bool
     */
    public function isInteractive(): bool
    {
        return MessageType::INTERACTIVE === $this->getType();
    }

    /**
     * Check if the message is a button reply message.
     *
     * @return bool
     */
    public function isButtonReply(): bool
    {
        return $this->isInteractive() && isset($this->message->button_reply);
    }

    /**
     * Check if the message is a text message.
     *
     * @return bool
     */
    public function isText(): bool
    {
        return MessageType::TEXT === $this->getType();
    }

    /**
     * Check if the message is an image message.
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return MessageType::IMAGE === $this->getType();
    }

    /**
     * Check if the message is a video message.
     *
     * @return bool
     */
    public function isVideo(): bool
    {
        return MessageType::VIDEO === $this->getType();
    }

    /**
     * Check if the message is an audio message.
     *
     * @return bool
     */
    public function isAudio(): bool
    {
        return MessageType::AUDIO === $this->getType();
    }

    /**
     * Check if the message is a document message.
     *
     * @return bool
     */
    public function isDocument(): bool
    {
        return MessageType::DOCUMENT === $this->getType();
    }

    /**
     * Check if the message is a location message.
     *
     * @return bool
     */
    public function isLocation(): bool
    {
        return MessageType::LOCATION === $this->getType();
    }

    /**
     * Check if the message is a contact message.
     *
     * @return bool
     */
    public function isContact(): bool
    {
        return MessageType::CONTACT === $this->getType();
    }

    /**
     * Check if the message is a sticker message.
     *
     * @return bool
     */
    public function isSticker(): bool
    {
        return MessageType::STICKER === $this->getType();
    }

    /**
     * Check if the message is a change of status.
     *
     * @return bool
     */
    public function isStatus(): bool
    {
        return MessageType::STATUS === $this->getType();
    }

    /**
     * Check if the message has a field status.
     *
     * @return bool
     */
    public function hasStatus(): bool
    {
        return isset($this->getMessage()->status);
    }

    /**
     * Cast the message to a text message.
     *
     * @return ShouldTextMessage
     *
     * @throws CastToTextException
     * @throws PropertyNoExists
     */
    public function toText(): ShouldTextMessage
    {
        if (!$this->isText()) {
            throw new CastToTextException();
        }

        return new TextMessage($this->getMessage());
    }

    /**
     * Cast the message to an interactive message.
     *
     * @return InteractiveMessage
     *
     * @throws CastToInteractiveException
     */
    public function toInteractive(): InteractiveMessage
    {
        if (!$this->isInteractive()) {
            throw new CastToInteractiveException();
        }

        return new InteractiveMessage($this);
    }

    /**
     * Cast the message to a media message.
     *
     * @return VideoMessage
     *
     * @throws CastToMediaException
     * @throws PropertyNoExists
     */
    public function toVideo(): VideoMessage
    {
        if (!$this->isVideo()) {
            throw new CastToMediaException();
        }

        return new VideoMessage($this->getMessage());
    }

    /**
     * Cast the message to a status message.
     *
     * @return ChangeStatusMessage
     *
     * @throws PropertyNoExists
     * @throws Exception
     */
    public function toStatus(): ChangeStatusMessage
    {
        if (!$this->isStatus()) {
            throw new Exception('Cannot cast to status');
        }

        return new ChangeStatusMessage($this->getMessage());
    }

    /**
     * Get the status of the message.
     *
     * @return ChangeStatusMessage
     *
     * @throws Exception
     */
    public function getStatus(): ChangeStatusMessage
    {
        return new ChangeStatusMessage($this->getMessage());
    }

    /**
     * Cast the message to a media message.
     *
     * @return ShouldMultimediaMessage
     * @throws CastToMediaException
     * @throws PropertyNoExists
     */
    public function toMedia(): ShouldMultimediaMessage
    {
        if (!$this->isMedia()) {
            throw new CastToMediaException();
        }

        return match ($this->getType()) {
            MessageType::IMAGE    => $this->toImage(),
            MessageType::VIDEO    => $this->toVideo(),
            MessageType::AUDIO    => $this->toAudio(),
            MessageType::DOCUMENT => $this->toDocument(),
            MessageType::STICKER  => $this->toSticker(),
            default               => throw new CastToMediaException(),
        };
    }

    /**
     * Cast the message to an image message.
     *
     * @return ImageMessage
     * @throws CastToMediaException
     * @throws PropertyNoExists
     */
    public function toImage(): ImageMessage
    {
        if (!$this->isImage()) {
            throw new CastToMediaException();
        }

        return new ImageMessage($this->getMessage());
    }

    /**
     * Cast the message to a document message.
     *
     * @return DocumentMessage
     * @throws CastToMediaException
     * @throws PropertyNoExists
     */
    public function toDocument(): DocumentMessage
    {
        if (!$this->isDocument()) {
            throw new CastToMediaException();
        }

        return new DocumentMessage($this->getMessage());
    }

    /**
     * Cast the message to a sticker message.
     *
     * @return StickerMessage
     * @throws CastToMediaException
     * @throws PropertyNoExists
     */
    public function toSticker(): StickerMessage
    {
        if (!$this->isSticker()) {
            throw new CastToMediaException();
        }

        return new StickerMessage($this->getMessage());
    }

    /**
     * Cast the message to an audio message.
     *
     * @return AudioMessage
     * @throws CastToMediaException
     * @throws PropertyNoExists
     */
    public function toAudio(): AudioMessage
    {
        if (!$this->isSticker()) {
            throw new CastToMediaException();
        }

        return new AudioMessage($this->getMessage());
    }

    /**
     * Check if the message is a media message.
     * @return bool
     */
    public function isMedia(): bool
    {
        return $this->getType()->isDownloadable();
    }
}
