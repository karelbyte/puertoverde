<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    use HasFactory;

    protected $fillable = [
          'user_id',
          'folio',
          'rate',
          'client_id',
          'created_at',
          'number_service',
          'average_cost',
          'annual_kilowatt',
          'annual_cost',
          'required_units',
          'units',
          'combined',
          'panel_capacity',
          'irradiation',
          'annual_kilowatt_round',
          'annual_cost_round',
          'total_annual',
          'total_kwh',
          'dls_change',
          'status',
          'note',
          'installation_id' ,
          'apply_inventory',
          'periods'
    ];

    protected $casts = [
        'combined' => 'boolean',
        'apply_inventory' => 'boolean',
        'periods' => 'boolean'
    ];

    public function scopeFreeForAll($query) {
        $user = auth()->user();
        if ($user->free_for_all) {
            return;
        }
        return $query->where('user_id', $user->id);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function consumptions () {
        return $this->hasMany(ServiceConsumption::class);
    }

    public function quotes () {
        return $this->hasMany(ServiceQuote::class);
    }

    public function sellers () {
        return $this->belongsToMany(User::class, 'service_sellers');
    }

    public function consumptionFirstPeriod () {
        return $this->consumptions->first();
    }

    public function consumptionLastPeriod () {
        return $this->consumptions->last();
    }


    public function consumptionskWhTotal () {
        if ($this->total_kwh && $this->total_kwh != 0) {
            return $this->total_kwh;
        }
        return  $this->consumptions->reduce(function ($carry,$item) {
            return $carry + $item->kwh;
        }, 0);
    }

    public function consumptionsTotal () {
        if ($this->total_annual && $this->total_annual != 0) {
            return $this->total_annual;
        }
        return  $this->consumptions->reduce(function ($carry,$item) {
            return $carry + $item->consumption;
        }, 0);
    }

    public function subtotal () {
        return  $this->quotes->reduce(function ($carry,$item) {
            return $carry + $item->amount;
        }, 0);

    }

    public function iva () {

        return $this->subTotal() * 0.16;
    }

    public function total () {

        return $this->totalDls() * $this->dls_change;
    }

    public function trees () {

        return $this->units  * 32;
    }

    public function productionGuaranteed() {
        $day = ($this->panel_capacity * $this->irradiation) / 1000;
        $month = $day * 30;
        $biMonth = $month * 2;
   //     $year =  $month * 12;
        $factor = $biMonth;
        if ($this->consumptions->count() == 12) {
            $factor =  $month;
        }
        return $factor * $this->units;
    }

    public function countperiods() {
      return  $this->consumptions->count() == 12;
    }

    public function totalDls () {
        return number_format($this->subTotal() + $this->iva(),  2, '.', '');
    }

}
