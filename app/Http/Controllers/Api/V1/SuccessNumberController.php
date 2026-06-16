<?php

namespace App\Http\Controllers\API\V1;

use App\Models\SuccessNumber;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuccessNumberResource;
use Illuminate\Support\Facades\Validator;

class SuccessNumberController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of success numbers.
     */
    public function index(): JsonResponse
    {
        $successNumbers = SuccessNumber::where('is_active', true)->get();
        
        return $this->success(
            SuccessNumberResource::collection($successNumbers),
            __('api.success_numbers_fetched_successfully')
        );
    }

    /**
     * Display the specified success number.
     */
    public function show($id): JsonResponse
    {
        $successNumber = SuccessNumber::find($id);
        
        if (!$successNumber) {
            return $this->error(
                __('api.success_number_not_found'),
                404
            );
        }
        
        return $this->success(
            new SuccessNumberResource($successNumber),
            __('api.success_number_fetched_successfully')
        );
    }

    
}

