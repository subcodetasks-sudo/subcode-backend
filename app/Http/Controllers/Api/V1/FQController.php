<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FQResource;
use App\Models\FQ;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class FQController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $fqs = FQ::all();
        
        return $this->success(
            FQResource::collection($fqs),
            __('api.fqs_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $fq = FQ::find($id);
        
        if (!$fq) {
            return $this->error(
                __('api.fq_not_found'),
                404
            );
        }
        
        return $this->success(
            new FQResource($fq),
            __('api.fq_fetched_successfully')
        );
    }
}