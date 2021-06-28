<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

use App\Person;
use App\User;

use Faker\Factory as Faker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    /**
     * Login as default API user and get token back.
     *
     * @return void
     */
    public function testLogin()
    {
        $baseUrl  = config('app.url') . '/api/auth/login';
        $email    = config('test.api.email');
        $password = config('test.api.password');

        $this->assertTrue($email === 'test@laravel.com');
        $this->assertTrue($password === 'laravel');

        $response = $this->json('POST', $baseUrl . '/', [
            'email'    => $email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    /**
     * Test logout.
     *
     * @return void
     */
    public function testLogout()
    {
        $email    = User::where('email', config('test.api.email'))->first();
        $token    = JWTAuth::fromUser($email);
        $baseUrl  = config('app.url') . '/api/auth/logout?token=' . $token;

        $response = $this->json('POST', $baseUrl, []);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }

    /**
     * Test token refresh.
     *
     * @return void
     */
    public function testRefresh()
    {
        $email    = User::where('email', config('test.api.email'))->first();
        $token    = JWTAuth::fromUser($email);
        $baseUrl  = config('app.url') . '/api/auth/refresh?token=' . $token;

        $response = $this->json('POST', $baseUrl, []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    /**
     * Test user register
     *
     * @return void
     */
    public function testRegister()
    {
        $baseUrl  = config('app.url') . '/api/auth/register';

        $faker = Faker::create();

        $name     = $faker->name();
        $username = $faker->userName();
        $email    = $faker->email();
        $password = 'laravel';

        $response = $this->json('POST', $baseUrl . '/', [
            'name'     => $name,
            'username' => $username,
            'email'    => $email,
            'password' => $password
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'message', 'user'
            ]);

        $userId = json_decode($response->getContent(), true)['user']['id'];

        $baseUrl  = config('app.url') . '/api/auth/login';

        $response = $this->json('POST', $baseUrl . '/', [
            'email'    => $email,
            'password' => $password
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);

        $person = Person::where('user_id', $userId)->first();
        $person->delete();

        $user = User::find($userId);
        $user->delete();

        $this->assertNull(Person::where('user_id', $userId)->first(), 'Problem removing person.');
        $this->assertNull(User::find($userId), 'Problem removing user.');
    }

    /**
     * Test get Profile
     */
    public function testGetProfile()
    {
        $user    = User::where('email', config('test.api.email'))->first();
        $token   = JWTAuth::fromUser($user);
        $baseUrl  = config('app.url') . '/api/auth/profile?token=' . $token;

        $response = $this->json('GET', $baseUrl . '/', []);

        $response->assertStatus(200);
    }
}
