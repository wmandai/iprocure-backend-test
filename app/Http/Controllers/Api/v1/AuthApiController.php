<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Users\UserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAdderRequest;
use App\Traits\InteractsWithAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    use InteractsWithAPI;

    public $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->request = $request;
    }

    public function login()
    {
        $this->request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $this->request->only('email', 'password');
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return $this->failed(['error' => 'Failed to authenticate, check credentials']);
        }

        return $this->respondWithToken($token);
    }

    public function register(UserAdderRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($this->request->password);
        try {
            $user = (new UserAction())->save($validatedData);
            $token = Auth::login($user);

            return $this->success([
                'message' => 'User created successfully',
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
            ], 201);
        } catch (\Exception $e) {
            return $this->failed(['error' => 'Failed to register user']);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();

            return $this->success([
                'message' => 'Successfully logged out',
            ]);
        } catch (\Exception $e) {
            return $this->failed(['error' => 'Failed to logout']);
        }
    }

    public function refresh()
    {
        return $this->success([
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->success([
            'user' => auth()->user(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ],
        ]);
    }
}
