<?php

use App\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create();

        // Generate user for make tests
        if (config('app.env') === 'test') {
            User::create([
                'username' => 'test.laravel',
                'email'    => 'test@laravel.com',
                'password' => Hash::make('laravel'),
            ]);
        }
    }
}
