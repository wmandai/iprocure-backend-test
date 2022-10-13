<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\InteractsWithREST;
use Tests\TestCase;
use Arr;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    use InteractsWithREST;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_view_without_authentication()
    {
        $this->getJson('/api/v1/users/show')->assertStatus(401);
    }

    public function test_create_without_authentication()
    {
        $this->postJson('/api/v1/users/new', [])->assertStatus(401);
    }

    public function test_delete_without_authentication()
    {
        $this->deleteJson('/api/v1/users/delete/123')->assertStatus(401);
    }
    public function test_crud_operations()
    {
        $payload = [
            'firstName' => $this->faker->unique()->firstName,
            'lastName' => $this->faker->unique()->lastName,
            'email'    => $this->faker->unique()->safeEmail,
            'password' => 'iproc@@',
        ];
        $this->createUserWithToken();
        $response = $this->postJson('/api/v1/users/new', $payload);
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $user     = $response->getData()->id;
        $response = $this->getJson('/api/v1/users/view/' . $user);
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->putJson('/api/v1/users/update/' . $user, Arr::prepend($payload, now()->toDateTimeString(), 'email_verified_at'));
        $response->assertStatus(200)->assertJson([
            'id' => true,
        ]);
        $response = $this->getJson('/api/v1/users/show');
        $response->assertStatus(200)->assertJson([
            'data' => true,
        ]);
        $response = $this->deleteJson('/api/v1/users/delete/' . $user);
        $response->assertStatus(200)->assertJson([
            'message' => true,
        ]);
    }

    public function test_get_undefined_user()
    {
        $this->createUserWithToken();
        $this->getJson('/api/v1/users/view/123')->assertStatus(404);
    }

    public function test_create_without_payload()
    {
        $this->createUserWithToken();
        $this->postJson('/api/v1/users/new', [])->assertStatus(422);
    }
}
