<?php


namespace App\Http\Controllers\Traits;


use App\Models\Setting;

trait SettingsTrait
{
    public function nextFolio() {

        $folio = Setting::where('key', 'folio')->first();
        $folio->value = $folio->value + 1;
        $folio->save();

        $prefix = Setting::where('key', 'folio_prefix')->first();

        return $prefix->value . $folio->value;
    }
}
