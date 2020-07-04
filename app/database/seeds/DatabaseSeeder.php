<?php

use Illuminate\Database\Seeder;
use App\Entities\PaymentStatus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();
        $this->call(PaymentStatusSeeder::class);
    }

    protected function truncate()
    {
        PaymentStatus::truncate();
    }
}
