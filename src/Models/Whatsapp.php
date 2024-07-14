<?php

namespace AiluraCode\Wappify\Models;

use AiluraCode\Wappify\Concern\IsMessageable;
use AiluraCode\Wappify\Concern\IsTransformable;
use AiluraCode\Wappify\Concern\IsValidable;
use AiluraCode\Wappify\Contracts\ShouldMessage;
use AiluraCode\Wappify\Enums\MessageType;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Whatsapp.
 *
 * @property int         $id
 * @property string      $wamid
 * @property string      $profile
 * @property string      $from
 * @property MessageType $type
 * @property object      $message
 * @property int         $timestamp
 */
class Whatsapp extends Model implements HasMedia, ShouldMessage
{
    use IsMessageable;
    use IsTransformable;
    use InteractsWithMedia;
    use IsValidable;

    public $timestamps = false;

    protected $table = 'whatsapp';

    /** @var array<int, string> */
    protected $fillable = [
        'wamid',
        'profile',
        'from',
        'type',
        'message',
        'timestamp',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'message' => 'object',
        'type'    => MessageType::class,
    ];

    /**
     * Delete the message with its media.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function deleteWithMedia(): void
    {
        $this->getMedia()->each(fn ($media) => $media->delete());
        $this->delete();
    }

    /**
     * Scope a query to only include messages from a specific number.
     *
     * @param QueryBuilder $query
     * @param string       $from
     *
     * @return QueryBuilder
     */
    public static function scopeFindByFrom(QueryBuilder $query, string $from): QueryBuilder
    {
        return $query->where('from', $from);
    }

    /**
     * Scope a query to get the last message by wamid.
     *
     * @param QueryBuilder $query
     * @param string       $wamid
     *
     * @return object|null
     */
    public static function scopeFindByWamid(QueryBuilder $query, string $wamid): ?object
    {
        return $query->where('wamid', $wamid)->first();
    }

    /**
     * Scope a query to get the last interactive message.
     *
     * @param QueryBuilder $query
     * @param string       $from
     *
     * @return QueryBuilder
     */
    public function scopeChat(QueryBuilder $query, string $from): QueryBuilder
    {
        return $query->where('from', $from)
            ->orderBy('timestamp', 'desc');
    }

    /**
     * Scope a query to get the messages sent.
     *
     * @param QueryBuilder $query
     *
     * @return QueryBuilder
     */
    public function scopeMe(QueryBuilder $query): QueryBuilder
    {
        return $query->where('wamid', 'LIKE', '%==');
    }

    /**
     * Scope a query to get the messages received.
     *
     * @param QueryBuilder $query
     *
     * @return QueryBuilder
     */
    public function scopeYou(QueryBuilder $query): QueryBuilder
    {
        return $query->where('wamid', 'NOT LIKE', '%==');
    }

    /**
     * Check if the message is a message from server.
     *
     * @return bool
     */
    public function isMine(): bool
    {
        return str_ends_with($this->wamid, '==');
    }

    /**
     * Check if the message is a message from the client.
     *
     * @return bool
     */
    public function isYour(): bool
    {
        return !$this->isMine();
    }

    /**
     * Scope a query to get the last message.
     *
     * @param QueryBuilder $query
     *
     * @return object|null
     */
    public function scopeLastMessage(QueryBuilder $query): ?object
    {
        return $query->orderBy('timestamp', 'desc')->first();
    }

    /**
     * Scope a query to get the last text message.
     *
     * @param QueryBuilder $query
     *
     * @return object|null
     */
    public function scopeLastTextMessage(QueryBuilder $query): ?object
    {
        return $query->where('type', MessageType::TEXT->value)
            ->orderBy('timestamp', 'desc')
            ->first();
    }

    /**
     * Get the last message of the chat.
     *
     * @param QueryBuilder $query
     *
     * @return object|null
     */
    public function lastInteractive(QueryBuilder $query): ?object
    {
        return $query->where('type', MessageType::INTERACTIVE->value)
            ->orderBy('timestamp', 'desc')
            ->first();
    }

    public function transferMedia(Model $model, string $collection = 'default', $deleteOriginal = false): void
    {
        $this->getMedia()->each(fn ($media) => $media->copy($model, $collection));
        if ($deleteOriginal) {
            $this->getMedia()->each(fn ($media) => $media->delete());
        }
    }
}
