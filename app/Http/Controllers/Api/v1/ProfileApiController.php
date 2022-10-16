<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\InteractsWithAPI;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    use InteractsWithAPI;

    public function profile(Request $request)
    {
        $user = auth()->user();

        return $this->success([
            'user' => [
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'email' => $user->email,
                'phone' => $user->phoneNumber,
                'created_at' => $user->created_at->toIso8601String(),
            ],
        ]);
    }
}
