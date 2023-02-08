<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Member::count() == 0) {
            Member::create([
                'id' => '5bbb6e30e3f98b2858a33661',
                'user_id' => 1,
                'user_name' => 'test_tale',
                'rate' => 8
            ]);
        }
    }
}
