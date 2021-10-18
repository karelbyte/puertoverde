<?php


namespace App\Http\Controllers\Traits;


use App\Models\Setting;

trait SettingsTrait
{
    public function nextFolio($type) {

        $folio = Setting::where('key', $type)->first();
        $folio->value = $folio->value + 1;
        $folio->save();

        $prefix = Setting::where('key', "{$type}_prefix")->first();

        return $prefix->value . $folio->value;
    }
}
