<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use App\Support\RedirectPathBuilder;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    use ApiResponse;

    public function resolve(Request $request): JsonResponse
    {
        $path = (string) $request->query('path', '');

        if (trim($path) === '') {
            return response()->json(['data' => null], 404);
        }

        $normalized = RedirectPathBuilder::normalizePath($path);

        $redirect = Redirect::query()
            ->active()
            ->where('source_path', $normalized)
            ->first();

        if (! $redirect) {
            $locale = RedirectPathBuilder::localeFromPath($normalized);
            $slug = trim(basename($normalized), '/');

            if ($locale && $slug !== '') {
                $redirect = Redirect::query()
                    ->active()
                    ->where('source_locale', $locale)
                    ->where('source_slug', $slug)
                    ->first();
            }
        }

        if (! $redirect) {
            return response()->json(['data' => null], 404);
        }

        return response()->json([
            'data' => [
                'source_path' => $redirect->source_path,
                'target_path' => $redirect->target_path,
                'status_code' => $redirect->status_code,
                'resource_type' => $redirect->resource_type,
                'locale' => $redirect->source_locale,
                'is_active' => $redirect->is_active,
            ],
        ]);
    }
}
