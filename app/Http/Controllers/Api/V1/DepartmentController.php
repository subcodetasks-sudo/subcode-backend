<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $departments = Department::with(['projects.meta', 'meta'])->get();

        return $this->success(
            DepartmentResource::collection($departments),
            __('api.departments_fetched_successfully')
        );
    }

    public function show($slug): JsonResponse
    {
        $lang = app()->getLocale();
        $department = Department::where("slug->{$lang}", $slug)
            ->with(['projects.meta', 'meta'])
            ->first();

        if (! $department) {
            return $this->error(
                __('api.department_not_found'),
                404
            );
        }

        return $this->success(
            new DepartmentResource($department),
            __('api.department_fetched_successfully')
        );
    }
}
