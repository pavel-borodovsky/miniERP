<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Invoice::count() == 0) {
            Invoice::create([
                'project_id' => 1,
                'date' => now(),
                'name' => 'Invoice 1 for project 1'
            ]);
        }
    }
}
