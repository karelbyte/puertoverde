<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'company',
        'code',
        'name',
        'type', // client, lead
        'address',
        'phones',
        'email',
        'note'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function services() {
        return $this->hasMany(ClientService::class);
    }

    public function scopeFreeForAll($query) {
        $user = auth()->user();
        if ($user->free_for_all || $user->admin) {
            return;
        }
        return $query->where('user_id', $user->id);
    }

    public function scopeSortBy($query, $sort, $order) {

        if (!$sort) {
            $sort = 'created_at';
        }
        $order = $order === 'true' ? 'desc' : 'asc';

        $query->orderBy($sort, $order);
    }


    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }

        $reg = '/\(|\)|\+| /i';
        $replacement = '';
        $strToCheck = preg_replace($reg, $replacement, $pattern);

        if (is_numeric($strToCheck)) {
            $clients = ClientService::where('number_service', 'like', '%'.$pattern.'%')->select('client_id');
            return $query->whereIn('id', $clients);
        }

        $users = User::where('name', 'like', '%'.$pattern.'%')->select('id');

        $clients = ClientService::where('folio', 'like', '%'.$pattern.'%')->select('client_id');

        $query->where('name', 'like', '%'.$pattern.'%')
            ->orWhere('email', 'like', '%'.$pattern.'%')
            ->orWhere('company', 'like', '%'.$pattern.'%')
            ->orWhereIn('user_id', $users)
            ->orWhereIn('id', $clients);
    }
}
