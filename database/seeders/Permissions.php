<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = collect( [
            [
                'name' => 'Control Diario',
                'value' => 'control'
            ],
            [
                'name' => 'Prospectos',
                'value' => 'prospect'
            ],
            [
                'name' => 'Clientes',
                'value' => 'clients'
            ],
            [
                'name' => 'Mantenimientos',
                'value' => 'maintenance'
            ],
            [
                'name' => 'Instalaciones',
                'value' => 'installations'
            ],
            [
                'name' => 'Almacenes',
                'value' => 'stock'
            ],
            [
                'name' => 'Usuarios',
                'value' => 'users'
            ],
            [
                'name' => 'Configuraciones',
                'value' => 'settings'
            ],
        ]);

        $data->each(function ($item) {
           Permission::create($item);
        });
    }
}
