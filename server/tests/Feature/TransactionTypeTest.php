<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

use App\Enums\OperationType;

use App\TransactionType;
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
     * Validate erros message from create transaction type
     *
     * @return void
     */
    public function testValidateMessageCreateTransactionType()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);
        $baseUrl = config('app.url') . '/api/transaction-types?token=' . $token;

        $response = $this->json('POST', $baseUrl . '/', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors']);

        $responseContent = json_decode($response->getContent(), true);

        $this->assertTrue(
            array_key_exists('code', $responseContent['errors']),
            'There is no validation for the code'
        );
        $this->assertTrue(
            array_key_exists('name', $responseContent['errors']),
            'There is no validation for the name'
        );
        $this->assertTrue(
            array_key_exists('operation', $responseContent['errors']),
            'There is no validation for the operation'
        );

        // Validate validions messages
        $this->assertEquals(
            'O campo código é obrigatório',
            $responseContent['errors']['code'][0],
            'The validation message for the code is incorrect.'
        );

        $this->assertEquals(
            'O campo nome é obrigatório',
            $responseContent['errors']['name'][0],
            'The validation message for the name is incorrect.'
        );

        $this->assertEquals(
            'O campo operação é obrigatório',
            $responseContent['errors']['operation'][0],
            'The validation message for the operation is incorrect.'
        );
    }

    /**
     * Validate update transaction type
     *
     * @return void
     */
    public function testUpdateTransactionType()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $transactionTypes = TransactionType::all();

        if ($transactionTypes->count() === 0) {
            $response = $this->createTransactionType($token);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'success', 'message', 'transaction_type'
                ]);

            $transactionType = (object) json_decode($response->getContent(), true)['transaction_type'];
        } else {
            $transactionType = $transactionTypes->random();
        }

        $baseUrl = config('app.url') . '/api/transaction-types/' . $transactionType->id . '?token=' . $token;

        $faker   = Faker::create();

        $response = $this->json('PUT', $baseUrl . '/', [
            'code'        => $transactionType->code,
            'name'        => $faker->name,
            'operation'   => OperationType::getValue($transactionType->operation),
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction_type'
            ]);

        $updatedTransactionType = (object) json_decode($response->getContent(), true)['transaction_type'];

        $this->assertEquals($transactionType->code, $updatedTransactionType->code);
        $this->assertNotEquals($transactionType->name, $updatedTransactionType->name);
        $this->assertEquals($transactionType->operation, $updatedTransactionType->operation);
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
