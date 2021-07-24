<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceQuote extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_service_id',
        'product_id',
        'quantity',
        'measure_id',
        'description',
        'price',
        'amount'
    ];

    public function measure () {
        return $this->belongsTo(Measure::class);
    }
}
