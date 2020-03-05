<?php

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
        $this->call(UserTableSeeder::class);
        $this->call(CostSeeder::class);
        $this->call(IncomeSeeder ::class);
        $this->call(LoanSeeder::class);
    }
}
