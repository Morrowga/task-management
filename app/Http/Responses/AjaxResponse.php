<?php

namespace App\Http\Responses;

class AjaxResponse
{
    public static function success($data = [], $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $statusCode);
    }

    public static function error($message = 'Error', $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}
