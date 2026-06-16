<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $services = Service::with(['features', 'meta'])->get();
        
        return $this->success(
            ServiceResource::collection($services),
            __('api.services_fetched_successfully')
        );
    }

    public function show($slugOrId): JsonResponse
    {
        $service = Service::with(['features', 'featureServices', 'meta'])
            ->findBySlugOrId($slugOrId);

        if (! $service) {
            return $this->error(
                __('api.service_not_found'),
                404
            );
        }

        return $this->success(
            new ServiceResource($service),
            __('api.service_fetched_successfully')
        );
    }
}