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

        $response = $this->createTransaction($account, $token);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction'
            ]);

        $createdTransaction = (object) json_decode($response->getContent(), true)['transaction'];

        $transaction = Transaction::where('id', $createdTransaction->id)
            ->where('account_id', $account->id)
            ->where('transaction_type_id', $createdTransaction->transaction_type_id)
            ->first();

        $this->assertNotNull($transaction);
    }

    /**
     * Validate update transaction by user account
     */
    public function testUpdateTransactionByUserAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $account         = $this->getAccount($user, $token);
        $transaction     = $this->getTransaction($account, $token);
        $transactionType = $this->getTransactionType($token);

        $baseUrl = config('app.url') . '/api/accounts/' . $account->id . '/transactions/' . $transaction->id . '?token=' . $token;

        $faker   = Faker::create();

        $response = $this->json('PUT', $baseUrl . '/', [
            'value'               => $faker->numberBetween(1, 500),
            'transaction_type_id' => $transactionType->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction'
            ]);

        $updatedTransaction = (object) json_decode($response->getContent(), true)['transaction'];

        $newTransaction = Transaction::find($updatedTransaction->id);

        $this->assertEquals($updatedTransaction->value, $newTransaction->value);
        $this->assertEquals($updatedTransaction->transaction_type_id, $newTransaction->transaction_type_id);
    }

    /**
     * Validate delete transaction by user account
     */
    public function testDestroyTransactionByUserAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $account     = $this->getAccount($user, $token);
        $transaction = $this->getTransaction($account, $token);

        $baseUrl = config('app.url') . '/api/accounts/' . $account->id . '/transactions/' . $transaction->id . '?token=' . $token;

        $response = $this->json('DELETE', $baseUrl . '/', []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction'
            ]);
    }

    /**
     * Validate delete all transactions by user account
     */
    public function testDestroyAllTransactionsByUserAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $account = $this->getAccount($user, $token);

        $quantidade = Transaction::where('account_id', $account->id)->count();

        if ($quantidade == 0) {
            $faker = Faker::create();

            $quantidadeTransacoes = $faker->numberBetween(2, 5);

            for ($i = 0; $i < $quantidadeTransacoes; $i++) {
                $this->createTransaction($account, $token);
            }
        }

        $quantidade = Transaction::where('account_id', $account->id)->count();

        $baseUrl = config('app.url') . '/api/accounts/' . $account->id . '/transactions/?token=' . $token;

        $response = $this->json('DELETE', $baseUrl . '/', []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'transaction'
            ]);

        $transactions = (array) json_decode($response->getContent(), true)['transaction'];

        $this->assertEquals($quantidade, sizeOf($transactions));

        $quantidade = Transaction::where('account_id', $account->id)->count();

        $this->assertEquals($quantidade, 0);
    }

    /**
     * Get Transaction
     *
     * @return Response
     */
    private function getTransaction($account, String $token)
    {
        $transactions = Transaction::where('account_id', $account->id)->get();

        if ($transactions->count() === 0) {
            $response = $this->createTransaction($account, $token);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'success', 'message', 'transaction'
                ]);

            $transaction = (object) json_decode($response->getContent(), true)['transaction'];
        } else {
            $transaction = $transactions->random();
        }

        return $account;
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
    private function getTransactionType(String $token)
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
     * Create transaction
     *
     * @return Response
     */
    private function createTransaction($account, String $token)
    {
        $baseUrl = config('app.url') . '/api/accounts/' . $account->id . '/transactions?token=' . $token;

        $faker = Faker::create();

        $transactionType = $this->getTransactionType($token);

        $response = $this->json('POST', $baseUrl . '/', [
            'value'               => $faker->numberBetween(0, 200),
            'transaction_type_id' => $transactionType->id,
        ]);

        return $response;
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
