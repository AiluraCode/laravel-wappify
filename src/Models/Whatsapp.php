<?php

namespace AiluraCode\Wappify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Whatsapp
 *
 * @property string $wa_id
 * @property string $from
 * @property string $type
 * @property int $timestamp
 * @property WhatsappMessages $message
 * @property WhatsappMedia $media
 * @property WhatsappMediaDocument $document
 * @property WhatsappMediaSticker $sticker
 * @property WhatsappMediaImage $image
 * @property WhatsappMediaLocation $location
 * @property WhatsappMediaAudio $audio
 * @property WhatsappMediaVideo $video
 * @package AiluraCode\Wappify\Models
 */
class Whatsapp extends Model
{

    protected $table = 'whatsapp';
    public $timestamps = false;

    protected $fillable = [
        'wa_id',
        'from',
        'type',
        'timestamp',
    ];

    public function message(): HasOne
    {
        if ($this->type != 'text') {
            throw new \Exception("This is not a $this->type");
        }
        return $this->hasOne(WhatsappMessages::class, 'whatsapp_id');
    }

    public function media(): HasOne
    {
        return $this->hasOne(WhatsappMedia::class, 'whatsapp_id');
    }

    public function document(): HasOne
    {
        if ($this->type != 'document') {
            throw new \Exception("This is not a $this->type");
        }
        return $this->hasOne(WhatsappMediaDocument::class, 'whatsapp_id');
    }

    public function sticker(): HasOne
    {
        if ($this->type != 'sticker') {
            throw new \Exception("This is not a $this->type");
        }
        return $this->hasOne(WhatsappMediaSticker::class, 'whatsapp_id');
    }

    public function image(): HasOne
    {
        if ($this->type != 'image') {
            throw new \Exception("This is not a $this->type");
        }
        return $this->hasOne(WhatsappMediaImage::class, 'whatsapp_id');
    }

    public function location(): HasOne
    {
        if ($this->type != 'location') {
            throw new \Exception("This is not a $this->type");
        }
        return $this->hasOne(WhatsappMediaLocation::class, 'whatsapp_id');
    }

    public function audio(): HasOne
    {
        if ($this->type != 'audio') {
            throw new \Exception("This is not a $this->type");
        }
        return $this->hasOne(WhatsappMediaAudio::class, 'whatsapp_id');
    }

    public function video(): HasOne
    {
        if ($this->type != 'video') {
            throw new \Exception("This is not a $this->type");
        }
        return $this->hasOne(WhatsappMediaVideo::class, 'whatsapp_id');
    }
}
