<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSeller extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_service_id',
        'user_id'
    ];
}
