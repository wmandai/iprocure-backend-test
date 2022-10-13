<?php

namespace App\Traits;

trait InteractsWithAPI
{
    protected function success($params)
    {
        return response()->json(array_merge($params, ['success' => true]));
    }
    protected function failed($params)
    {
        return response()->json(array_merge($params, ['success' => false]));
    }

    protected function unauthorized()
    {
        return response()->json(['message' => 'Unauthorized', 'success' => false], 401);
    }
}
