<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutUsResource;
use App\Models\AboutUs;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AboutUsController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $aboutUs = AboutUs::with('meta')->first();
        
        return $this->success(
            new AboutUsResource($aboutUs),
            __('api.about_us_fetched_successfully')
        );
    }

    // public function show($id): JsonResponse
    // {
    //     $aboutUs = AboutUs::find($id);
        
    //     if (!$aboutUs) {
    //         return $this->error(
    //             __('api.about_us_not_found'),
    //             404
    //         );
    //     }
        
    //     return $this->success(
    //         new AboutUsResource($aboutUs),
    //         __('api.about_us_fetched_successfully')
    //     );
    // }
}