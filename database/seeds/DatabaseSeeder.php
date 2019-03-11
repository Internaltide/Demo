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
        // fill in status data
        $this->call([
            StatusDataSeeder::class,
            DefaultRoleSeeder::class
        ]);
    }
}
