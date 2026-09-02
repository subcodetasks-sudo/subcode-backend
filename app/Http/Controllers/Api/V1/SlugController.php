<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Support\SlugResourceCollector;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SlugController extends Controller
{
    use ApiResponse;

    public function index(Request $request, ?string $locale = null): JsonResponse
    {
        $locale = $locale ?? $request->query('locale', 'ar');
        $collector = new SlugResourceCollector;

        if ($request->boolean('all_locales')) {
            return $this->success(
                Cache::remember('slugs.all_locales', 3600, fn () => $collector->collectAllBilingual()),
                __('api.slugs_fetched_successfully')
            );
        }

        if (! in_array($locale, ['ar', 'en', 'tr'], true)) {
            return $this->error(__('api.invalid_locale'), 422);
        }

        return $this->success(
            Cache::remember("slugs.{$locale}", 3600, fn () => $collector->collectAllForLocale($locale)),
            __('api.slugs_fetched_successfully')
        );
    }
}
