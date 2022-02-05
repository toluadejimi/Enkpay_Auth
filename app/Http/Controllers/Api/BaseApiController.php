<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    public function sendResponse($result, $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ]);
    }

    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
