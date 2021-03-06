<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Documentable extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'documentable_type',
        'documentable_id',
        'type',
        'quantity',
        'total',
    ];

    public function documentable()
    {
        return $this->morphTo();
    }

}
