<?php

namespace Tests\Feature;

use App\Models\Product;
use Arr;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\InteractsWithREST;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    use InteractsWithREST;

    public function test_cannot_view_products_without_authentication()
    {
        $this->getJson('/api/v1/products/show')->assertStatus(401);
    }

    public function test_cannot_create_products_without_authentication()
    {
        $this->postJson('/api/v1/products/new', [])->assertStatus(401);
    }

    public function test_cannot_delete_products_without_authentication()
    {
        $this->deleteJson('/api/v1/products/delete/123')->assertStatus(401);
    }

    public function test_can_create_update_delete_products()
    {
        $this->createUserWithToken();
        $payload = [
            'name' => 'Almatix',
            'description' => 'Tick controls',
            'type' => 'acaricide',
            'category' => 'general',
            'quantity' => 1,
            'unit_cost' => 350,
            'manufacturer' => 'Norbrook',
            'distributor' => 'Solai Agrovet',
            'user_id' => auth()->id(),
        ];
        // create a new product
        $response = $this->postJson('/api/v1/products/new', $payload);
        $response->assertStatus(201)->assertJson([
            'id' => true,
        ]);
        $productId = $response->getData()->id;
        // test product can be seen
        $response = $this->getJson('/api/v1/products/view/'.$productId);
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        // test updating product
        $response = $this->putJson('/api/v1/products/update/'.$productId, Arr::prepend($payload, 380, 'unit_cost'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        // test product listing
        $response = $this->getJson('/api/v1/products/show');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        // test can search products
        $response = $this->postJson('/api/v1/products/search', ['search' => 'Almatix']);
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        // test that application can delete product
        $response = $this->deleteJson('/api/v1/products/delete/'.$productId);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_cannot_view_missing_product()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/products/view/123')->assertStatus(404);
    }

    public function test_creating_product_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/products/new', [])->assertStatus(422);
    }

    public function test_cannot_delete_missing_product()
    {
        $this->createUserWithToken();
        $this->deleteJson('/api/v1/products/delete/123')->assertStatus(404);
    }
}
