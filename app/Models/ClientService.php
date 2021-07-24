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
          'panel_capacity',
          'irradiation',
          'annual_kilowatt_round',
          'annual_cost_round',
          'dls_change',
          'status',
          'note'
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
        return  $this->consumptions->reduce(function ($carry,$item) {
            return $carry + $item->kwh;
        }, 0);
    }

    public function consumptionsTotal () {
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

        return $this->required_units  * 32;
    }

    public function productionGuaranteed() {
        $day = ($this->panel_capacity * $this->irradiation) / 1000;
        $month = $day * 30;
        $biMonth = $month * 2;
        $year =  $month * 12;
        $factor = $biMonth;
        if ($this->consumptions->count() == 12) {
            $factor = $year;
        }
        return $factor * $this->required_units;
    }

    public function totalDls () {
        return number_format($this->subTotal() + $this->iva(),  2, '.', '');
    }

}