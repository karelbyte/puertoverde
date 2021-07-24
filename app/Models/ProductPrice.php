<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'percent_apply',
        'price',
        'sale_price',
        'default',
        'used'
    ];

    protected $casts = [
        'price' => 'double',
        'sale_price' => 'double',
        'default' => 'boolean',
        'used' => 'boolean'
    ];

}
