<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeaturePackageResource;
use App\Models\FeaturePackage;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class FeaturePackageController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $featurePackages = FeaturePackage::all();
        
        return $this->success(
            FeaturePackageResource::collection($featurePackages),
            __('api.feature_packages_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $featurePackage = FeaturePackage::with('package')->find($id);
        
        if (!$featurePackage) {
            return $this->error(
                __('api.feature_package_not_found'),
                404
            );
        }
        
        return $this->success(
            new FeaturePackageResource($featurePackage),
            __('api.feature_package_fetched_successfully')
        );
    }
}