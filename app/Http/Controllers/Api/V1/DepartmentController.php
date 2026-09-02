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
        $departments = Department::with([
            'meta',
            'projects' => fn ($query) => $query->where('status', 1),
            'projects.meta',
            'projects.department',
        ])->get();

        return $this->success(
            DepartmentResource::collection($departments),
            __('api.departments_fetched_successfully')
        );
    }

    public function show($slug): JsonResponse
    {
        $lang = app()->getLocale();
        $department = Department::where("slug->{$lang}", $slug)
            ->with([
                'meta',
                'projects' => fn ($query) => $query->where('status', 1),
                'projects.meta',
                'projects.department',
            ])
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
