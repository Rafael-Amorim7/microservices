<?php

namespace App\Models;

use App\Models\Device;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = [
        'latitude',
        'longitude',
        'device_id'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
