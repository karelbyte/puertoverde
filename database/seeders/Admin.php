<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $permissions = Permission::all();

       $user =  User::create([
           'name' => 'admin',
           'email' => 'admin@puertoverde.net',
           'status' => 1,
           'password' => Hash::make('secret'),
           'admin' => 1,
           'seller' => 1,
       ]);

        foreach ($permissions as $permission) {
            UserPermission::create([
                'user_id' => $user->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}
