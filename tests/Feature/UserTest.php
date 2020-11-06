<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Passport\Passport;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * authenticate
     * Create user and authenticate the user
     *
     * @return array
     */
    protected function authenticate(){
        \Artisan::call('passport:install');
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        Passport::actingAs($user);
        $token = $user->createToken('myapi')->accessToken;
        $headers = [ 'Authorization' => 'Bearer $token'];

        return $headers;
    }

    /**
     * testGetUser
     * A basic feature test Get User.
     *
     * @return void
     */
    public function testGetUser()
    {
        $headers = $this->authenticate();
        $response = $this->json('GET', '/api/user', [], $headers);
        $response->assertStatus(200);
    }

    /**
     * testGetUserProducts
     * A basic feature test Get Products.
     *
     * @return void
     */
    public function testGetUserProducts()
    {
        $headers = $this->authenticate();
        $response = $this->json('GET', '/api/user/products', [], $headers);
        $response->assertStatus(200);
    }

    /**
     * testSetUserProducts
     * A basic feature test Set Products.
     *
     * @return void
     */

    public function testSetUserProducts()
    {
        $headers = $this->authenticate();
        $payload = [
            'user_id' => 1,
            'product_sku' => 'battery-4'
        ];
        $response = $this->json('POST', '/api/user/products', $payload, $headers);
        $response->assertStatus(200);
    }

    /**
     * testDeletePurchase
     * A basic feature test delete Purchase.
     *
     * @return void
     */

    public function testDeletePurchase()
    {
        $headers = $this->authenticate();

        $response = $this->json('DELETE', '/api/user/products/battery-4', [], $headers);
        $response->assertStatus(200);
    }
}
