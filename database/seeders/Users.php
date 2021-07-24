<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = User::factory()->count(50)->make();
       $permissions = Permission::all();

       $users->each(function ($user) use ($permissions) {
           $permissions = $permissions->take(rand(1,5));
           $user =  User::create($user->getAttributes());
           foreach ($permissions as $permission) {
               UserPermission::create([
                   'user_id' => $user->id,
                   'permission_id' => $permission->id
               ]);
           }
       });
    }
}
