<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewProjectResource;
use App\Models\ReviewProject;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ReviewProjectController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $reviewProjects = ReviewProject::with('project')->get();
        
        return $this->success(
            ReviewProjectResource::collection($reviewProjects),
            __('api.review_projects_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $reviewProject = ReviewProject::with('project')->find($id);
        
        if (!$reviewProject) {
            return $this->error(
                __('api.review_project_not_found'),
                404
            );
        }
        
        return $this->success(
            new ReviewProjectResource($reviewProject),
            __('api.review_project_fetched_successfully')
        );
    }
}