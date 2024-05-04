<?php

namespace AiluraCode\Wappify\Models;

use AiluraCode\Wappify\Enums\MessageType;
use AiluraCode\Wappify\Http\Clients\WhatsappClientDownloader;
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

    protected $fillable = [
        'wa_id',
        'from',
        'type',
        'message',
        'timestamp',
    ];

    protected $casts = [
        'message' => 'array',
        'type' => MessageType::class,
    ];

    public function download()
    {
        return WhatsappClientDownloader::download($this);
    }

    public function setFilename(): string
    {
        if ($this->type->isDownloadable())
            return str_replace("wamid.", "", $this->wa_id) . '.' . explode('/', $this->message['mime_type'])[1];
        else return '';
    }

    public function deleteWithMedia()
    {
        $this->media->each->delete();
        $this->delete();
    }
}
