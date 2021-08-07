<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'min'
    ];


    public function product () {
        return $this->belongsTo(Product::class);
    }


    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }

    }
}