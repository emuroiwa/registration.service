<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * @test
     * Test Auth
     */
    public function testAuth()
    {
        //Create user
        \Artisan::call('passport:install');
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        Passport::actingAs($user);
        //attempt Auth
        $payload = [
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ];
        $response = $this->json('POST', '/api/auth', $payload);
        //Assert it was successful and a token was received
        $response->assertStatus(200);

        //Delete the user
        User::where('email','test@gmail.com')->delete();
    }
}
