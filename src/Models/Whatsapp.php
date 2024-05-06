<?php

namespace AiluraCode\Wappify\Models;

use AiluraCode\Wappify\Enums\MessageType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Whatsapp
 *
 * @property int $id
 * @property string $wa_id
 * @property string $from
 * @property MessageType $type
 * @property mixed $message
 * @property int $timestamp
 * @property string $message["id"]
 * @property string $message["mime_type"]
 * @property string $message["sha256"]
 * @property string $message["filename"]
 * @property string $message["body"]
 * @property string $message["latitude"]
 * @property string $message["longitude"]
 * @property string $message["animated"]
 * @property string $message["voice"]
 * @package AiluraCode\Wappify\Models
 */
class Whatsapp extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'whatsapp';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'profile',
        'from',
        'type',
        'message',
        'timestamp',
    ];

    protected $casts = [
        'message' => 'object',
        'type' => MessageType::class,
        'timestamp' => 'datetime',
    ];

    public function deleteWithMedia()
    {
        $this->media->each->delete();
        $this->delete();
    }

    public static function findByFrom(string $from): Builder
    {
        return self::whereFrom($from);
    }

    public static function findByWaId(string $waId): Collection
    {
        return self::whereWaId($waId)->get();
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
        return self::where('id', 'LIKE', '%==');
    }

    public function scopeYou(): Builder
    {
        return self::where('id', 'NOT LIKE', '%==');
    }
}
