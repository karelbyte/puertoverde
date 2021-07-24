<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percent extends Model
{
    use HasFactory;

    protected $fillable = [
        'percentage',
        'default'
    ];

    protected $casts = [
        'default' => 'boolean',
    ];

    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }

        $query->where('percentage', 'like', $pattern .'%');
    }
}
