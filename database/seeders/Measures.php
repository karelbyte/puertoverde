<?php

namespace Database\Seeders;

use App\Models\Measure;
use Illuminate\Database\Seeder;

class Measures extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $measures = collect( [
           'Unidad',
           'Pieza',
           'Metro',
           'Rollo',
           'Paquete'
       ]);

       $measures->each(function ($measure)  {
           Measure::create([
               'name' => $measure
           ]);
       });
    }
}
