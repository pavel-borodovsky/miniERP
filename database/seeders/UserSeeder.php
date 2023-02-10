<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0){
            User::create([
                'name' => 'test_tale',
                'email' => 'test@tale.by',
                'password' => 'test',
                'isActive' => 1
            ]);
        }
    }
}
