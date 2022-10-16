<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\InteractsWithREST;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    use InteractsWithREST;

    public function test_cannot_login_without_email_password()
    {
        $this->postJson('/api/v1/auth/login', [])->assertStatus(422);
    }

    public function test_cannot_login_with_wrong_credentials()
    {
        $this->postJson('/api/v1/auth/login', [
            'email' => 'johndoe@test.com',
            'password' => 'avengers',
        ])->assertStatus(400);
    }

    public function test_can_register_and_login()
    {
        $payload = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'johndoe@mail.com',
            'password' => 'avengers',
            'phone' => '2547220000000',
        ];
        // register new user and get token
        $response = $this->postJson('/api/v1/auth/register', $payload);
        $response->assertStatus(201)->assertJson([
            'authorization' => true,
        ]);
        $this->postJson('/api/v1/auth/login', ['email' => $payload['email'], 'password' => $payload['password']])->assertStatus(200);
    }

    public function test_customer_cannot_create_roles()
    {
        $this->createUserWithToken('Customer');
        $this->postJson('/api/v1/roles/new', ['name' => 'Editor', 'guard_name' => 'web'])->assertStatus(401);
    }

    public function test_customer_cannot_create_users()
    {
        $this->createUserWithToken('Customer');
        $this->postJson('/api/v1/users/new', [
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'janedoe@example.com',
            'password' => 'jane@@',
        ])->assertStatus(401);
    }

    public function test_customer_can_search_products()
    {
        $this->createUserWithToken('Customer');
        $this->postJson('/api/v1/products/search', ['search' => 'almatix'])->assertStatus(200);
    }
}
