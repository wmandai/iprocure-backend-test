<?php

namespace App\Traits;

trait InteractsWithAPI
{
    protected function success($params, $code = 200)
    {
        return response()->json(array_merge($params, ['success' => true]), $code);
    }
    protected function failed($params, $code = 400)
    {
        return response()->json(array_merge($params, ['success' => false]), $code);
    }

    protected function unauthorized()
    {
        return response()->json(['message' => 'Unauthorized', 'success' => false], 401);
    }
}
