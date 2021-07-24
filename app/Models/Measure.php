<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }

        $query->where('name', 'like', $pattern .'%');
    }
}
