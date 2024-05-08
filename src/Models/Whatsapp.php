<?php

namespace AiluraCode\Wappify\Models;

use AiluraCode\Wappify\Enums\MessageType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Whatsapp
 *
 * @property int $id
 * @property string $wamid
 * @property string $profile
 * @property string $from
 * @property MessageType $type
 * @property object $message
 * @property int $timestamp
 * @package AiluraCode\Wappify\Models
 */
class Whatsapp extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'whatsapp';
    public $timestamps = false;

    protected $fillable = [
        'wamid',
        'profile',
        'from',
        'type',
        'message',
        'timestamp',
    ];

    protected $casts = [
        'message' => 'object',
        'type' => MessageType::class,
    ];

    public function deleteWithMedia()
    {
        $this->media->each->delete();
        $this->delete();
    }

    #region scopes

    public static function scopefindByFrom($query, string $from): Builder
    {
        return $query->whereFrom($from);
    }

    public static function findByWamid(string $wamid): Whatsapp
    {
        return self::whereWamid($wamid)->first();
    }

    public function scopeLastMessage($query): Whatsapp
    {
        return $query->orderBy('timestamp', 'desc')->first();
    }

    public function scopeLastTextMessage($query): Whatsapp
    {
        return $query->whereType("text")->orderBy('timestamp', 'desc')->first();
    }

    public function scopeChat($query, string $from): Builder
    {
        return $query->whereFrom($from)->orderBy('timestamp', 'desc');
    }

    public function scopeMe(): Builder
    {
        return self::where('wamid', 'LIKE', '%==');
    }

    public function scopeYou(): Builder
    {
        return self::where('wamid', 'NOT LIKE', '%==');
    }

    #endregion

    /**
     * Get the type of the message
     * @return MessageType
     */
    public function getType(): MessageType
    {
        return $this->type;
    }


    #region checks

    /**
     * Check if the message is a message from server
     *
     * @return boolean
     */
    public function isMine(): bool
    {
        return str_ends_with($this->wamid, "==");
    }

    /**
     * Check if the message is a message from client
     *
     * @return boolean
     */
    public function isYour(): bool
    {
        return !$this->isMy();
    }

    /**
     * Check if the message is a interactive message
     *
     * @return boolean
     */
    public function isInteractive(): bool
    {
        return $this->type === MessageType::INTERACTIVE;
    }

    /**
     * Check if the message is a button reply message
     *
     * @return boolean
     */
    public function isButtonReply(): bool
    {
        return $this->isInteractive() && isset($this->message->button_reply);
    }

    /**
     * Check if the message is a text message
     *
     * @return boolean
     */
    public function isText(): bool
    {
        return $this->type === MessageType::TEXT;
    }

    /**
     * Check if the message is a image message
     *
     * @return boolean
     */
    public function isImage(): bool
    {
        return $this->type === MessageType::IMAGE;
    }

    /**
     * Check if the message is a video message
     *
     * @return boolean
     */
    public function isVideo(): bool
    {
        return $this->type === MessageType::VIDEO;
    }

    /**
     * Check if the message is a audio message
     *
     * @return boolean
     */
    public function isAudio(): bool
    {
        return $this->type === MessageType::AUDIO;
    }

    /**
     * Check if the message is a document message
     *
     * @return boolean
     */
    public function isDocument(): bool
    {
        return $this->type === MessageType::DOCUMENT;
    }

    /**
     * Check if the message is a location message
     *
     * @return boolean
     */
    public function isLocation(): bool
    {
        return $this->type === MessageType::LOCATION;
    }

    /**
     * Check if the message is a contact message
     *
     * @return boolean
     */
    public function isContact(): bool
    {
        return $this->type === MessageType::CONTACT;
    }

    /**
     * Check if the message is a sticker message
     *
     * @return boolean
     */
    public function isSticker(): bool
    {
        return $this->type === MessageType::STICKER;
    }

    #endregion

    // TODO

    public function lastInteractive()
    {
        return $this->where('type', 'interactive')->orderBy('timestamp', 'desc')->first();
    }

    public function interactiveType()
    {
        return $this->message->type;
    }

    #region Get Information

    /**
     * Get the text of the message (only for text type)
     * @return string
     */
    public function getText(): string
    {
        return $this->message->body;
    }

    /**
     * Get the origin number of the message
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Get the message object
     * @return object
     */
    public  function getMessage(): object
    {
        return $this->message;
    }

    public function getButtonReply(): object
    {
        return $this->message->button_reply;
    }

    #endregion

    #region Casts

    /**
     * Cast the message to a text message
     *
     * @return string
     */
    public function toText(): string
    {
        // si no es un mensaje de texto
        if (!$this->isText()) {
            throw new \Exception("The message is not a text message");
        }
        return $this->message->body;
    }

    /**
     * Cast the message to a interactive message
     *
     * @return WhatsappInteractiveMessage
     */
    public function toInteractive(): WhatsappInteractiveMessage
    {
        if (!$this->isInteractive()) {
            throw new \Exception("The message is not a interactive message");
        }
        return new WhatsappInteractiveMessage($this->message);
    }
}
