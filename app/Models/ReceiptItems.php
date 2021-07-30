<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ReceiptItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receipt_id',
        'product_id',
        'quantity',
    ];

}
