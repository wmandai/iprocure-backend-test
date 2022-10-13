<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\InteractsWithREST;
use Arr;

class RoleTest extends TestCase
{
    use DatabaseTransactions;
    use InteractsWithREST;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_view_without_authentication()
    {
        $this->getJson('/api/v1/roles/show')->assertStatus(401);
    }

    public function test_create_without_authentication()
    {
        $this->postJson('/api/v1/roles/new', [])->assertStatus(401);
    }

    public function test_delete_without_authentication()
    {
        $this->deleteJson('/api/v1/roles/delete/123')->assertStatus(401);
    }

    public function test_crud_operations()
    {
        $this->createUserWithToken();

        $role_id = Role::factory()->create()->id;
        $payload = [
            'name' => 'Editor',
            'guard_name' => 'web'
        ];
        $response = $this->postJson('/api/v1/roles/new', $payload);
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $role = $response->getData()->id;
        $response = $this->getJson('/api/v1/roles/view/' . $role);
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->putJson('/api/v1/roles/update/' . $role, Arr::prepend($payload, 'api', 'guard_name'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $response = $this->getJson('/api/v1/roles/show');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->deleteJson('/api/v1/roles/delete/' . $role);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_get_undefined_role()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/roles/view/123')->assertStatus(404);
    }

    public function test_create_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/roles/new', [])->assertStatus(422);
    }

    public function test_delete_undefined_role()
    {
        $this->createUserWithToken();
        $this->deleteJson('/api/v1/roles/delete/123')->assertStatus(404);
    }
}
