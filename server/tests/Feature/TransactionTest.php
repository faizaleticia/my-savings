<?php

namespace Tests\Feature;

use App\Account;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

use App\Transaction;
use App\TransactionType;
use App\User;

use Faker\Factory as Faker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionTest extends TestCase
{
    /**
     * Create an transaction by user account
     *
     * @return void
     */
    public function testCreateTransactionByUserAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $account = $this->getAccount($user, $token);

        $baseUrl = config('app.url') . '/api/accounts/' . $account->id . '/transactions?token=' . $token;

        $faker = Faker::create();

        $transactionType = $this->getTransactionTypes($token);

        $response = $this->json('POST', $baseUrl . '/', [
            'value'               => $faker->numberBetween(0, 200),
            'transaction_type_id' => $transactionType->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction'
            ]);

        $createdTransaction = (object) json_decode($response->getContent(), true)['transaction'];

        $transaction = Transaction::where('id', $createdTransaction->id)
            ->where('account_id', $account->id)
            ->where('transaction_type_id', $transactionType->id)
            ->first();

        $this->assertNotNull($transaction);
    }

    /**
     * Get account
     *
     * @return Response
     */
    private function getAccount(User $user, String $token)
    {
        $accounts = Account::where('user_id', $user->id)->get();

        if ($accounts->count() === 0) {
            $response = $this->createAccount($user, $token);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'success', 'message', 'account'
                ]);

            $account = (object) json_decode($response->getContent(), true)['account'];
        } else {
            $account = $accounts->random();
        }

        return $account;
    }

    /**
     * Get transaction type
     *
     * @return Response
     */
    private function getTransactionTypes(String $token)
    {
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

        return $transactionType;
    }

    /**
     * Create account
     *
     * @return Response
     */
    private function createAccount(User $user, String $token)
    {
        $baseUrl = config('app.url') . '/api/accounts?token=' . $token;

        $faker = Faker::create();

        $response = $this->json('POST', $baseUrl . '/', [
            'letter'      => strtoupper($faker->randomLetter()),
            'name'        => $faker->company(),
            'description' => $faker->catchPhrase(),
            'color'       => strtoupper($faker->hexcolor()),
            'user_id'     => $user->id,
        ]);

        return $response;
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
