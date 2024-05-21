<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Concern;

use AiluraCode\Wappify\Contracts\ShouldMediaMessage;
use AiluraCode\Wappify\Entities\ChangeStatusMessage;
use AiluraCode\Wappify\Entities\Interactive\InteractiveMessage;
use AiluraCode\Wappify\Entities\Media\AudioMessage;
use AiluraCode\Wappify\Entities\Media\DocumentMessage;
use AiluraCode\Wappify\Entities\Media\ImageMessage;
use AiluraCode\Wappify\Entities\Media\StickerMessage;
use AiluraCode\Wappify\Entities\Media\VideoMessage;
use AiluraCode\Wappify\Entities\ShouldTextMessage;
use AiluraCode\Wappify\Enums\MessageStatusType;
use AiluraCode\Wappify\Enums\MessageType;
use AiluraCode\Wappify\Exceptions\CastToInteractiveException;
use AiluraCode\Wappify\Exceptions\CastToMediaException;
use AiluraCode\Wappify\Exceptions\CastToTextException;
use Exception;

trait Transformable
{
    /**
     * Check if the message is an interactive message.
     *
     * @return bool
     */
    public function isInteractive(): bool
    {
        return MessageType::INTERACTIVE === $this->type;
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
        return MessageType::TEXT === $this->type;
    }

    /**
     * Check if the message is an image message.
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return MessageType::IMAGE === $this->type;
    }

    /**
     * Check if the message is a video message.
     *
     * @return bool
     */
    public function isVideo(): bool
    {
        return MessageType::VIDEO === $this->type;
    }

    /**
     * Check if the message is an audio message.
     *
     * @return bool
     */
    public function isAudio(): bool
    {
        return MessageType::AUDIO === $this->type;
    }

    /**
     * Check if the message is a document message.
     *
     * @return bool
     */
    public function isDocument(): bool
    {
        return MessageType::DOCUMENT === $this->type;
    }

    /**
     * Check if the message is a location message.
     *
     * @return bool
     */
    public function isLocation(): bool
    {
        return MessageType::LOCATION === $this->type;
    }

    /**
     * Check if the message is a contact message.
     *
     * @return bool
     */
    public function isContact(): bool
    {
        return MessageType::CONTACT === $this->type;
    }

    /**
     * Check if the message is a sticker message.
     *
     * @return bool
     */
    public function isSticker(): bool
    {
        return MessageType::STICKER === $this->type;
    }

    /**
     * Check if the message is a change of status.
     *
     * @return bool
     */
    public function isStatus(): bool
    {
        return MessageType::STATUS === $this->type;
    }

    /**
     * Check if the message has a field status.
     *
     * @return bool
     */
    public function hasStatus(): bool
    {
        return isset($this->message->status);
    }

    /**
     * Cast the message to a text message.
     *
     * @return ShouldTextMessage
     *
     * @throws Exception
     */
    public function toText(): ShouldTextMessage
    {
        if (!$this->isText()) {
            throw new CastToTextException();
        }

        return new ShouldTextMessage($this->getMessage());
    }

    /**
     * Cast the message to an interactive message.
     *
     * @return InteractiveMessage
     *
     * @throws Exception
     */
    public function toInteractive(): InteractiveMessage
    {
        if (!$this->isInteractive()) {
            throw new CastToInteractiveException();
        }

        return new InteractiveMessage($this);
    }

    /**
     * @throws CastToMediaException
     * @throws Exception
     */
    public function toVideo(): VideoMessage
    {
        if (!$this->isVideo()) {
            throw new CastToMediaException();
        }

        return new VideoMessage($this->getMessage());
    }

    /**
     * @throws CastToMediaException
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
     * @throws CastToMediaException
     * @throws Exception
     */
    public function getStatus(): ChangeStatusMessage
    {
        if (!$this->hasStatus()) {
            $message = $this->getMessage();
            $message->status = MessageStatusType::WAITING->value;
            $this->message = $message;
        }

        return new ChangeStatusMessage($this->getMessage());
    }

    /**
     * @throws CastToMediaException
     * @throws Exception
     */
    public function toMedia(): ShouldMediaMessage
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
     * @throws CastToMediaException
     * @throws Exception
     */
    public function toImage(): ImageMessage
    {
        if (!$this->isImage()) {
            throw new CastToMediaException();
        }

        return new ImageMessage($this->getMessage());
    }

    /**
     * @throws CastToMediaException
     * @throws Exception
     */
    public function toDocument(): DocumentMessage
    {
        if (!$this->isDocument()) {
            throw new CastToMediaException();
        }

        return new DocumentMessage($this->getMessage());
    }

    /**
     * @throws CastToMediaException
     * @throws Exception
     */
    public function toSticker(): StickerMessage
    {
        if (!$this->isSticker()) {
            throw new CastToMediaException();
        }

        return new StickerMessage($this->getMessage());
    }

    /**
     * @throws CastToMediaException
     * @throws Exception
     */
    public function toAudio(): AudioMessage
    {
        if (!$this->isSticker()) {
            throw new CastToMediaException();
        }

        return new AudioMessage($this->getMessage());
    }

    /**
     * @return bool
     */
    public function isMedia(): bool
    {
        return $this->getType()->isDownloadable();
    }
}
