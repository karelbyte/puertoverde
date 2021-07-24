<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
       'company',
       'name',
       'email1',
       'email2',
       'phones',
       'address1',
       'address2'
    ];

    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }

        $query->where('name', 'like', $pattern .'%')
            ->orWhere('email1', 'like', $pattern.'%')
             ->orWhere('email2', 'like', $pattern.'%');
    }

}
