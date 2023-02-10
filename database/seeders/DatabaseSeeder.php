<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Console\Commands\ConnectTrello;
use App\Models\Booker;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(BookerSeeder::class);
        $this->call(ProjectSeeder::class);
        $sync = new ConnectTrello();
        $sync->handle();
        $this->call(InvoiceSeeder::class);
        $this->call(InvoiceTaskSeeder::class);
    }
}
