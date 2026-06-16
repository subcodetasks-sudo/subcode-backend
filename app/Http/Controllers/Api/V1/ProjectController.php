<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Project;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\LiteProjectResource;

class ProjectController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'department_id' => 'sometimes|integer|exists:departments,id',
        ]);
        $projects = Project::with(['department', 'advantageProjects', 'reviewProjects', 'meta']);

        if ($request->has('department_id')) {
            $projects->where('department_id', $request->department_id);
        }
        $projects = $projects->where('status', 1)->paginate(15);

        return $this->PaginationResponse(
            LiteProjectResource::collection($projects),
            __('api.projects_fetched_successfully')
        );
    }

    public function show($slugOrId): JsonResponse
    {
        $project = Project::with(['department', 'advantageProjects', 'reviewProjects', 'meta'])
            ->findBySlugOrId($slugOrId);

        if (! $project) {
            return $this->error(
                __('api.project_not_found'),
                404
            );
        }

        return $this->success(
            new ProjectResource($project),
            __('api.project_fetched_successfully')
        );
    }


    public function specialProjects(): JsonResponse
    {
       
        $projects = Project::with(['department', 'advantageProjects', 'reviewProjects', 'meta'])->where('is_special', true)->paginate(15);


        return $this->PaginationResponse(
            LiteProjectResource::collection($projects),
            __('api.projects_fetched_successfully')
        );
    }
}
