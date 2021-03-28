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
        $this->call(MenuItemSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(AccountSeed::class);
    }
}
