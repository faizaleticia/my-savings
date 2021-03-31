<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

use App\User;

use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionTypeTest extends TestCase
{
    /**
     * Get all transaction types.
     *
     * @return void
     */
    public function testGetTransactionTypes()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);
        $baseUrl = config('app.url') . '/api/transaction-types?token=' . $token;

        $response = $this->json('GET', $baseUrl . '/', []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction_types'
            ]);
    }
}
