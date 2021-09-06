<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $hidden = ['pivot'];

    protected $fillable = [
        'name',
        'code',
        'price_id',
        'type',
        'provider_id',
        'description',
        'measure_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function inventory () {
        return $this->hasOne(Inventory::class);
    }

    public function measure () {
        return $this->belongsTo(Measure::class);
    }

    public function price () {
        return $this->belongsTo(ProductPrice::class);
    }

    public function prices () {
        return $this->hasMany(ProductPrice::class);
    }

    public function gettype() {
        return  $this->type == 'inventory' ? 'Producto' : 'Servicio';
    }

    public function provider() {
        return $this->belongsTo(Provider::class);
    }

    public function providers() {
        return $this->belongsToMany(Provider::class, 'product_providers');
    }

    public function relates() {
        return $this->belongsToMany(Product::class, 'product_relates', 'product_id', 'relate_id')
            ->withPivot('quantity')
            ->select('product_relates.relate_id as id', 'products.name', 'product_relates.quantity');
    }

    public function scopeTemplate($query, $template) {

        if (!$template) {
            return;
        }
        switch ($template) {
            case 'list':
                $query->select('id', 'name', 'code', 'created_at');
            break;
        }

    }

    public function scopeFilter($query, $pattern) {

        if (!$pattern) {
            return;
        }

        $query->where('name', 'like', '%' . $pattern .'%')
            ->orWhere('description', 'like', '%' .$pattern.'%')
            ->orWhere('code', 'like','%' . $pattern.'%');
    }

    public function scopeStatus($query, $status) {

        if (!$status) {
            return;
        }

        $query->where('status', $status);
    }

    public function scopeType($query, $type) {

        if (!$type) {
            return;
        }

        $query->where('type', $type);
    }

    function attachProviders($providers) {
        $providers = collect($providers);
        $providers->each(function ($provider)  {
            $this->providers()->attach($provider['id']);
        });
    }

    function attachRelates($relates) {
        $relates = collect($relates);
        $relates->each(function ($relate)  {
            $this->relates()->attach([
                $relate['id'] => [ 'quantity' => $relate['quantity'] ]
            ]);
        });
    }

}
