<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceConsumption extends Model
{
    use HasFactory;

    protected $fillable = [
      'client_service_id',
      'period',
      'kwh',
      'consumption'
    ];
}
