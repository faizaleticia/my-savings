<?php

namespace Tests\Feature;

use App\Enums\OperationType;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

use App\User;

use Faker\Factory as Faker;
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

    /**
     * Create an transaction type.
     *
     * @return void
     */
    public function testCreateTransactionType()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $response = $this->createTransactionType($token);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction_type'
            ]);
    }

    /**
     * Create transaction type
     *
     * @return Response
     */
    private function createTransactionType(String $token)
    {
        $baseUrl = config('app.url') . '/api/transaction-types?token=' . $token;

        $faker = Faker::create();

        $response = $this->json('POST', $baseUrl . '/', [
            'code'      => $faker->numberBetween(0, 10),
            'name'      => $faker->name,
            'operation' => $faker->numberBetween(0, 1),
        ]);

        return $response;
    }
}
