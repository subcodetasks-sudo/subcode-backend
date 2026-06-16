<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Success response
     */
    protected function success(
        $data = [],
        string $message = '',
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Error response
     */
    protected function error(
        string $message = '',
        int $statusCode = Response::HTTP_OK,
        $status = false
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [],
        ], $statusCode);
    }

    public function PaginationResponse($result, $message = '', $code = 200)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $result,
            'pagination' => [
                'currentPage' => $result->currentPage(),
                'lastPage' => $result->lastPage(),
                'perPage' => $result->perPage(),
                'total' => $result->total(),
            ]
            ];
        return response()->json($response, $code);
    }
}