<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerSuccessResource;
use App\Models\PartnerSuccess;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class PartnerSuccessController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $partnerSuccesses = PartnerSuccess::all();
        
        return $this->success(
            PartnerSuccessResource::collection($partnerSuccesses),
            __('api.partner_successes_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $partnerSuccess = PartnerSuccess::find($id);
        
        if (!$partnerSuccess) {
            return $this->error(
                __('api.partner_success_not_found'),
                404
            );
        }
        
        return $this->success(
            new PartnerSuccessResource($partnerSuccess),
            __('api.partner_success_fetched_successfully')
        );
    }
}