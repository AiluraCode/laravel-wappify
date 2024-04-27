<?php

namespace AiluraCode\Wappify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMediaLocation extends Model
{

    protected $table = 'whatsapp_media';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'whatsapp_id',
        'latitude',
        'longitude',
        'address',
        'name',
        'url',
        'data',
    ];

    protected $hidden = [
        'data',
        'mime_type',
        'sha256',
        'id',
    ];

    protected $appends = [
        'latitude',
        'longitude',
        'address',
        'name',
        'url',
    ];

    protected $casts = [
        'data' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function setLatitudeAttribute($value)
    {
        $this->data = [
            'latitude' => $value,
            'longitude' => $this->getLongitudeAttribute(),
            'name' => $this->getNameAttribute(),
            'address' => $this->getAddressAttribute(),
            'url' => $this->getUrlAttribute()
        ];
    }

    public function setLongitudeAttribute($value)
    {
        $this->data = [
            'latitude' => $this->getLatitudeAttribute(),
            'longitude' => $value,
            'name' => $this->getNameAttribute(),
            'address' => $this->getAddressAttribute(),
            'url' => $this->getUrlAttribute()
        ];
    }

    public function setNameAttribute($value)
    {
        $this->data = [
            'latitude' => $this->getLatitudeAttribute(),
            'longitude' => $this->getLongitudeAttribute(),
            'name' => $value,
            'address' => $this->data['address'],
            'url' => $this->data['url']
        ];
    }

    public function setAddressAttribute($value)
    {
        $this->data = [
            'latitude' => $this->getLatitudeAttribute(),
            'longitude' => $this->getLongitudeAttribute(),
            'name' => $this->getNameAttribute(),
            'address' => $value,
            'url' => $this->getUrlAttribute()
        ];
    }

    public function setUrlAttribute($value)
    {
        $this->data = [
            'latitude' => $this->getLatitudeAttribute(),
            'longitude' => $this->getLongitudeAttribute(),
            'name' => $this->getNameAttribute(),
            'address' => $this->getAddressAttribute(),
            'url' => $value
        ];
    }

    public function getLatitudeAttribute()
    {
        return $this->data['latitude'];
    }

    public function getLongitudeAttribute()
    {
        return $this->data['longitude'];
    }

    public function getAddressAttribute()
    {
        return $this->data['address'] ?? null;
    }

    public function getNameAttribute()
    {
        return $this->data['name'] ?? null;
    }

    public function getUrlAttribute()
    {
        return $this->data['url'] ?? null;
    }

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
