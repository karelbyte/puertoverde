<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'moment',
        'document',
        'note',
        'amount',
        'status'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function items () {
        return $this->hasMany(ReceiptItems::class);
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
