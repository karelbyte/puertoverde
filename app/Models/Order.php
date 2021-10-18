<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'moment',
        'receipt_id',
        'document',
        'note',
        'amount',
        'status'
    ];

    protected $casts = [
        'moment' => 'datetime',
    ];


    public function user () {
        return $this->belongsTo(User::class);
    }

    public function items () {
        return $this->hasMany(OrderItems::class);
    }


    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }


        $users = User::where('name', 'like', '%'.$pattern.'%')->select('id');

        $query->where('doc', 'like', '%'.$pattern.'%')
            ->orWhere('note', 'like', '%'.$pattern.'%')
            ->orWhereIn('user_id', $users);
    }
}
