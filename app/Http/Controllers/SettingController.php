<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\SettingsTrait;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use SettingsTrait;

    public function index(Request $request) {

        try {

            $settings = Setting::all();

            $settings = $settings->map(function ($set) {
                if ($set->type == 'toggle') {
                    $set->value =(boolean) $set->value;
                }
                return $set;
            });

            return  [
                'total' => 0,
                'data' =>  $settings,
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $setting = Setting::findOrFail($id);

            $setting->fill($request->all())->save();

            return http_response_code(200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSetting($key) {
        try {

            $setting = Setting::where('key', $key)->first();
            $value = '';
            switch ($setting->type) {
                case 'input':
                   $value = is_numeric($setting->value) ?  is_double($setting->value) ? (double) $setting->value : (int)  $setting->value: $setting->value;
                   break;
                case 'toggle':
                   $value = (boolean) $setting->value;
            }

            return response()->json(['data' => $value], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCurrentMoneyChange() {

        try {

            $currentChange = Setting::where('key', 'money_change_type')->first();

            return response()->json(['data' => $currentChange->value], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getNextFolio() {

        try {

            return response()->json(['data' => $this->nextfolio()], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
