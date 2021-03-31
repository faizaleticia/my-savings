<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use DatabaseMigrations {
        runDatabaseMigrations as baseRunDatabaseMigrations;
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->baseRunDatabaseMigrations();
        $this->seed();

        $user = User::create([
            'username' => 'test.laravel',
            'email'    => config('test.api.email'),
            'password' => Hash::make(config('test.api.password')),
        ]);
    }
}
