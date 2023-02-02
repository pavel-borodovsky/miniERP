<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::count() == 0) {
            Role::create([
                'role' => 'Admin',
            ]);
            Role::create([
                'role' => 'Guest',
            ]);
        }
        $users = User::all();
        foreach ($users as $user) {
            if ($user->id == 1) {
                $user->roles()->attach(1);
            }
            else {
                $user->roles()->attach(2);
            }
        }
    }
}
