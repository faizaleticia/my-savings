<?php

use App\Person;
use App\User;

use Faker\Factory as Faker;

use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 50; $i++) {
            $usersAvailable = User::doesnthave('person')->get()->pluck('id');

            Person::create([
                'name'    => $faker->name,
                'user_id' => $faker->randomElement($usersAvailable),
            ]);
        }
    }
}
