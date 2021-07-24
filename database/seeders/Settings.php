<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $settings = new Setting();

       $items = [
           [
               'id' => 1,
               'key' => 'folio_prefix',
               'description' => 'Prefijo de folio',
               'value' => 'PVZ',
           ],
           [
              'id' => 2,
              'key' => 'folio',
              'description' => 'Folio',
              'value' => 1000
            ],
            [
               'id' => 3,
               'key' => 'money_change_type',
               'description' => 'Tipo de cambio',
               'value' => 1
           ],
       ];
      foreach ($items as $item ) {
          $settings->create($item);
      }
    }
}
