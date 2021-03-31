<?php

namespace Tests\Feature;

use App\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\User;

use Faker\Factory as Faker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AccountTest extends TestCase
{
    /**
     * Get all accounts of user.
     *
     * @return void
     */
    public function testGetAccounts()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);
        $baseUrl = config('app.url') . '/api/accounts?token=' . $token;

        $response = $this->json('GET', $baseUrl . '/', []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'accounts'
            ]);
    }

    /**
     * Create an account.
     *
     * @return void
     */
    public function testCreateAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $response = $this->createAccount($user, $token);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'account'
            ]);
    }

    /**
     * Validate erros message from create account
     *
     * @return void
     */
    public function testValidateMessageCreateAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);
        $baseUrl = config('app.url') . '/api/accounts?token=' . $token;

        $response = $this->json('POST', $baseUrl . '/', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors']);

        $responseContent = json_decode($response->getContent(), true);

        // Validate validations
        $this->assertTrue(
            array_key_exists('letter', $responseContent['errors']),
            'There is no validation for the letter'
        );
        $this->assertTrue(
            array_key_exists('name', $responseContent['errors']),
            'There is no validation for the name'
        );
        $this->assertTrue(
            array_key_exists('description', $responseContent['errors']),
            'There is no validation for the description'
        );
        $this->assertTrue(
            array_key_exists('color', $responseContent['errors']),
            'There is no validation for the color'
        );

        // Validate validions messages
        $this->assertEquals(
            'O campo letra é obrigatório',
            $responseContent['errors']['letter'][0],
            'The validation message for the letter is incorrect.'
        );

        $this->assertEquals(
            'O campo nome é obrigatório',
            $responseContent['errors']['name'][0],
            'The validation message for the name is incorrect.'
        );

        $this->assertEquals(
            'O campo descrição é obrigatório',
            $responseContent['errors']['description'][0],
            'The validation message for the description is incorrect.'
        );

        $this->assertEquals(
            'O campo cor é obrigatório',
            $responseContent['errors']['color'][0],
            'The validation message for the color is incorrect.'
        );
    }

    /**
     * Validate update account
     *
     * @return void
     */
    public function testUpdateAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $account = Account::where('user_id', $user->id)->get()->random();

        if (!$account) {
            $response = $this->createAccount($user, $token);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'success', 'message', 'account'
                ]);

            $account  = json_decode($response->getContent(), true)['account'];
        }

        $baseUrl = config('app.url') . '/api/accounts/' . $account->id . '?token=' . $token;

        $faker   = Faker::create();

        $response = $this->json('PUT', $baseUrl . '/', [
            'letter'      => $account['letter'],
            'name'        => $account['name'],
            'description' => $faker->catchPhrase(),
            'color'       => $account['color'],
            'user_id'     => $user->id,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'account'
            ]);

        $updatedAccount = json_decode($response->getContent(), true)['account'];

        $this->assertEquals($account['letter'], $updatedAccount['letter']);
        $this->assertEquals($account['name'], $updatedAccount['name']);
        $this->assertNotEquals($account['description'], $updatedAccount['description']);
        $this->assertEquals($account['color'], $updatedAccount['color']);
        $this->assertEquals($account['user_id'], $updatedAccount['user_id']);
    }

    /**
     * Validate delete account
     */
    public function testDestroyAccount()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);

        $account = Account::where('user_id', $user->id)->get()->random();

        if (!$account) {
            $response = $this->createAccount($user, $token);

            $response
                ->assertStatus(200)
                ->assertJsonStructure([
                    'success', 'message', 'account'
                ]);

            $account  = json_decode($response->getContent(), true)['account'];
        }

        $baseUrl = config('app.url') . '/api/accounts/' . $account->id . '?token=' . $token;

        $response = $this->json('DELETE', $baseUrl . '/', []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success', 'message', 'account'
            ]);
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
}
