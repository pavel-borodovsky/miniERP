<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Status::count() == 0) {
            Status::create([
                'name' => 'На утверждении'
            ]);
            Status::create([
                'name' => 'Закрыт'
            ]);
            Status::create([
                'name' => 'В работе'
            ]);
        }
    }
}
