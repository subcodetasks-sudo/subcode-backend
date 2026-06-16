<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $admins = Admin::where('is_active', true)->get();
        
        return $this->success(
            AdminResource::collection($admins),
            __('api.admins_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $admin = Admin::find($id);
        
        if (!$admin) {
            return $this->error(
                __('api.admin_not_found'),
                404
            );
        }
        
        return $this->success(
            new AdminResource($admin),
            __('api.admin_fetched_successfully')
        );
    }
}
