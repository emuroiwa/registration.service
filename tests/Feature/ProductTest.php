<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test Products.
     *
     * @return void
     */
    public function testProducts()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }
}
