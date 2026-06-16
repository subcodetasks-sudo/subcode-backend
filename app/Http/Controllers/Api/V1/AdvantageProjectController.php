<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvantageProjectResource;
use App\Models\AdvantageProject;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AdvantageProjectController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $advantageProjects = AdvantageProject::with('project')->get();
        
        return $this->success(
            AdvantageProjectResource::collection($advantageProjects),
            __('api.advantage_projects_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $advantageProject = AdvantageProject::with('project')->find($id);
        
        if (!$advantageProject) {
            return $this->error(
                __('api.advantage_project_not_found'),
                404
            );
        }
        
        return $this->success(
            new AdvantageProjectResource($advantageProject),
            __('api.advantage_project_fetched_successfully')
        );
    }
}