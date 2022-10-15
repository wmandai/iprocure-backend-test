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

    public function test_cannot_view_roles_without_authentication()
    {
        $this->getJson('/api/v1/roles/show')->assertStatus(401);
    }

    public function test_cannot_create_roles_without_authentication()
    {
        $this->postJson('/api/v1/roles/new', [])->assertStatus(401);
    }

    public function test_cannot_delete_roles_without_authentication()
    {
        $this->deleteJson('/api/v1/roles/delete/123')->assertStatus(401);
    }

    public function test_can_create_update_delete_roles()
    {
        $this->createUserWithToken();
        $payload = [
            'name' => 'Editor',
            'guard_name' => 'web'
        ];
        // test creating new role
        $response = $this->postJson('/api/v1/roles/new', $payload);
        $response->assertStatus(201)->assertJson([
            'id' => true,
        ]);
        $roleId = $response->getData()->id;
        // test role can be seen
        $response = $this->getJson('/api/v1/roles/view/' . $roleId);
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        // test role can be updated
        $response = $this->putJson('/api/v1/roles/update/' . $roleId, Arr::prepend($payload, 'api', 'guard_name'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        // test role listings
        $response = $this->getJson('/api/v1/roles/show');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        // test deleting roles
        $response = $this->deleteJson('/api/v1/roles/delete/' . $roleId);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_cannot_view_missing_role()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/roles/view/123')->assertStatus(404);
    }

    public function test_cannot_create_role_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/roles/new', [])->assertStatus(422);
    }

    public function test_cannot_delete_missing_role()
    {
        $this->createUserWithToken();
        $this->deleteJson('/api/v1/roles/delete/123')->assertStatus(404);
    }
}
