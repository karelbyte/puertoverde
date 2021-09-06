<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class InventoryFixItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_fix_id',
        'product_id',
        'quantity',
    ];

    public function product() {
       return $this->belongsTo(Product::class);
    }

}
