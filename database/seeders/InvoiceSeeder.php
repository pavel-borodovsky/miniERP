<?php

namespace Database\Seeders;

use App\Models\Board;
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
            $board = Board::all()->first();
            Invoice::create([
                'project_id' => 1,
                'date' => now(),
                'name' => 'Test invoice for test project and test board',
                'idBoard' => $board->idBoard
            ]);
        }
    }
}
