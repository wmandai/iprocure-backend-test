<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Arr;
use Tests\InteractsWithREST;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    use InteractsWithREST;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_view_without_authentication()
    {
        $this->getJson('/api/v1/products/show')->assertStatus(401);
    }

    public function test_create_without_authentication()
    {
        $this->postJson('/api/v1/products/new', [])->assertStatus(401);
    }

    public function test_delete_without_authentication()
    {
        $this->deleteJson('/api/v1/products/delete/123')->assertStatus(401);
    }

    public function test_crud_operations()
    {
        $this->createUserWithToken();

        $product_id = Product::factory()->create()->id;
        $payload = [
            'name' => 'Almatix',
            'description' => 'Tick controls',
            'type' => 'acaricide',
            'category' => 'controls',
            'quantity' => 1,
            'unit_cost' => 350,
            'manufacturer' => 'Norbrook',
            'distributor' => 'Solai Agrovet',
            'user_id' => auth()->id()
        ];

        $response = $this->postJson('/api/v1/products/new', $payload);
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $product = $response->getData()->id;
        $response = $this->getJson('/api/v1/products/view/' . $product);
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->putJson('/api/v1/products/update/' . $product, Arr::prepend($payload, 380, 'unit_cost'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $response = $this->getJson('/api/v1/products/show');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->deleteJson('/api/v1/products/delete/' . $product);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_get_undefined_product()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/products/view/123')->assertStatus(404);
    }

    public function test_create_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/products/new', [])->assertStatus(422);
    }

    public function test_delete_undefined_product()
    {
        $this->createUserWithToken();
        $this->deleteJson('/api/v1/products/delete/123')->assertStatus(404);
    }
}
