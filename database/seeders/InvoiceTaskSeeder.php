<?php

namespace Database\Seeders;

use App\Models\InvoiceTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPUnit\Framework\MockObject\Invocation;

class InvoiceTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(InvoiceTask::count() == 0) {
            InvoiceTask::create([
                'invoice_id' => 1,
                'desc' => 'Test InvoiceTask',
                'tag' => '#tag'
            ]);
        }
    }
}
