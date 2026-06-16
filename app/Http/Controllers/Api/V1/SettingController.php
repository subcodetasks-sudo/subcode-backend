<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $setting = Setting::query()->first();

        if (! $setting) {
            return $this->success([], __('api.settings_fetched_successfully'));
        }

        return $this->success(
            new SettingResource($setting),
            __('api.settings_fetched_successfully')
        );
    }

    public function show(int $id): JsonResponse
    {
        $setting = Setting::query()->find($id);

        if (! $setting) {
            return $this->error(__('api.setting_not_found'), 404);
        }

        return $this->success(
            new SettingResource($setting),
            __('api.setting_fetched_successfully')
        );
    }

    public function scripts(): JsonResponse
    {
        $setting = Setting::query()->first();

        return $this->success([
            'custom_head_scripts' => $setting?->custom_head_scripts,
            'custom_body_scripts' => $setting?->custom_body_scripts,
            'robots_txt' => $setting?->robots_txt,
            'google_analytics' => $setting?->google_analytics,
            'facebook_pixel' => $setting?->facebook_pixel,
        ], __('api.settings_fetched_successfully'));
    }

    public function robots(): Response
    {
        $setting = Setting::query()->first();
        $content = $setting?->robots_txt ?: "User-agent: *\nAllow: /\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
