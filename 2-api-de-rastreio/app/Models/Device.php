<?php

namespace App\Models;

use App\Models\Location;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = [
        'nome',
        'codigo',
        'ativo',
        'marca'
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
