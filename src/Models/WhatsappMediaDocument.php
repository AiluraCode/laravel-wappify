<?php

namespace AiluraCode\Wappify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMediaDocument extends Model
{

    protected $table = 'whatsapp_media';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'mime_type',
        'sha256',
        'whatsapp_id',
        'id',
    ];

    protected $appends = [
        'filename'
    ];

    protected $hidden = [
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'filename' => 'string'
    ];

    public function getFilenameAttribute()
    {
        return $this->data['filename'];
    }

    public function setFilenameAttribute(string $value)
    {
        $this->data = [
            'filename' => $value
        ];
    }

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
