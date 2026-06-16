<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class FeatureController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $features = Feature::with('service')->get();
        
        return $this->success(
            FeatureResource::collection($features),
            __('api.features_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $feature = Feature::with('service')->find($id);
        
        if (!$feature) {
            return $this->error(
                __('api.feature_not_found'),
                404
            );
        }
        
        return $this->success(
            new FeatureResource($feature),
            __('api.feature_fetched_successfully')
        );
    }
}