<?php

use App\Account;

use Faker\Factory as Faker;

use Illuminate\Database\Seeder;

class AccountSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        Account::create([
            'name'        => $faker->company,
            'description' => $faker->catchPhrase,
            'letter'      => strtoupper($faker->randomLetter),
            'color'       => strtoupper($faker->hexcolor),
        ]);
    }
}
