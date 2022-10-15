<?php

namespace Tests\Feature;

use Arr;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\InteractsWithREST;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    use InteractsWithREST;

    public function test_cannot_view_users_without_authentication()
    {
        $this->getJson('/api/v1/users/show')->assertStatus(401);
    }

    public function test_cannot_create_user_without_authentication()
    {
        $this->postJson('/api/v1/users/new', [])->assertStatus(401);
    }

    public function test_cannot_delete_user_without_authentication()
    {
        $this->deleteJson('/api/v1/users/delete/123')->assertStatus(401);
    }
    public function test_can_create_update_delete_users()
    {
        $payload = [
            'firstName' => $this->faker->unique()->firstName,
            'lastName' => $this->faker->unique()->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'iproc@@',
        ];
        $this->createUserWithToken();
        // test creating new user
        $response = $this->postJson('/api/v1/users/new', $payload);
        $response->assertStatus(201)->assertJson([
            'id' => true,
        ]);
        $userId = $response->getData()->id;
        // test user can be seen
        $response = $this->getJson('/api/v1/users/view/' . $userId);
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        // test user can be updated
        $response = $this->putJson('/api/v1/users/update/' . $userId, Arr::prepend($payload, now()->toDateTimeString(), 'email_verified_at'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        // test users listings
        $response = $this->getJson('/api/v1/users/show');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        // test user can be deleted
        $response = $this->deleteJson('/api/v1/users/delete/' . $userId);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_cannot_view_missing_user()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/users/view/123')->assertStatus(404);
    }

    public function test_cannot_create_user_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/users/new', [])->assertStatus(422);
    }
}
