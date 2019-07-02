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
        //$this->call([UsersTableSeeder::class]);
        $this->call([CompaniesTableSeeder::class]);
        $this->call([AgentsTableSeeder::class]);
        $this->call([AdminsTableSeeder::class]);
    }
}
