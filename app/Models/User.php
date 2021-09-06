<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'admin',
        'seller',
        'manager_percentage',
        'manager_price',
        'free_for_all',
        'installer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
        'admin' => 'boolean',
        'seller' => 'boolean',
        'manager_percentage' => 'boolean',
        'manager_price' => 'boolean',
        'free_for_all' => 'boolean',
        'installer' => 'boolean'
    ];

    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }

        $query->where('name', 'like', $pattern .'%')
              ->orWhere('email', 'like', $pattern.'%');
    }

    public function scopeSeller($query, $seller) {

        if (!$seller) {
            return;
        }

        $query->where('seller', $seller);
    }

    public function Permissions() {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

}
