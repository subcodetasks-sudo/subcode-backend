<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamMemberResource;
use App\Models\TeamMember;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamMemberController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of team members.
     */
    public function index(): JsonResponse
    {
        $teamMembers = TeamMember::where('is_active', true)->get();
        
        return $this->success(
            TeamMemberResource::collection($teamMembers),
            __('api.team_members_fetched_successfully')
        );
    }

    /**
     * Display the specified team member.
     */
    public function show($id): JsonResponse
    {
        $teamMember = TeamMember::find($id);
        
        if (!$teamMember) {
            return $this->error(
                __('api.team_member_not_found'),
                404
            );
        }
        
        return $this->success(
            new TeamMemberResource($teamMember),
            __('api.team_member_fetched_successfully')
        );
    }


}

