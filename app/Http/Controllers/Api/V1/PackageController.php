<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Package;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;

class PackageController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'nullable|string|max:20|in:programming,marketing',
        ]);

        $packages = Package::with('meta')->where('status', 1)
            ->when($request->filled('type'), function ($q) use ($request) {
                $q->where('type', $request->type);
            })
            ->get();

        return $this->success(
            PackageResource::collection($packages),
            __('api.packages_fetched_successfully')
        );
    }

    public function show($slugOrId): JsonResponse
    {
        $package = Package::with('meta')->findBySlugOrId($slugOrId);

        if (! $package) {
            return $this->error(
                __('api.package_not_found'),
                404
            );
        }

        return $this->success(
            new PackageResource($package),
            __('api.package_fetched_successfully')
        );
    }
}
