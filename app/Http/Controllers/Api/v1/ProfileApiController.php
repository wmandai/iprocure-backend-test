<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\InteractsWithAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileApiController extends Controller
{
    use InteractsWithAPI;

    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }
}
