<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait InteractsWithREST
{
    protected $headers = [];

    protected $scopes = [];

    protected $user;

    public function createUserWithToken($role = 'Admin')
    {
        $this->user = User::factory()->create();
        $this->user->syncRoles($role);
        $token = Auth::login($this->user);
        $this->headers['Accept'] = 'application/json';
        $this->headers['Authorization'] = 'Bearer '.$token;
    }

    public function getJson($uri, array $headers = [])
    {
        return parent::getJson($this->addBaseUrl($uri), array_merge($this->headers, $headers));
    }

    public function postJson($uri, array $data = [], array $headers = [])
    {
        return parent::postJson($this->addBaseUrl($uri), $data, array_merge($this->headers, $headers));
    }

    public function putJson($uri, array $data = [], array $headers = [])
    {
        return parent::putJson($this->addBaseUrl($uri), $data, array_merge($this->headers, $headers));
    }

    public function deleteJson($uri, array $data = [], array $headers = [])
    {
        return parent::deleteJson($this->addBaseUrl($uri), $data, array_merge($this->headers, $headers));
    }

    protected function addBaseUrl($uri)
    {
        return config('app.url').$uri;
    }
}
