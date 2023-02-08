<?php

namespace Database\Seeders;

use App\Models\Booker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Booker::count() == 0) {
            Booker::create([
                'user_id' => 1,
                'trello_token' => 'ATTA037207c2cb1f78ad47fac31c3b379c7f6ae893fc3aaa685a44803a7680f32fbbE61C6A51'
            ]);
        }
    }
}
