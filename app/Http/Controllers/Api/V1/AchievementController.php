<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AchievementResource;
use App\Models\Achievement;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $achievements = Achievement::query()->with('meta')->latest()->get();

        return $this->success(
            AchievementResource::collection($achievements),
            __('api.achievements_fetched_successfully')
        );
    }

    public function show(int $id): JsonResponse
    {
        $achievement = Achievement::query()->with('meta')->find($id);

        if (! $achievement) {
            return $this->error(
                __('api.achievement_not_found'),
                404
            );
        }

        return $this->success(
            new AchievementResource($achievement),
            __('api.achievement_fetched_successfully')
        );
    }
}
