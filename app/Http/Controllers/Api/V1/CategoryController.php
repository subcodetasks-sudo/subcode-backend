<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $categories = Category::withCount('blogs')->with('meta')->get();
        
        return $this->success(
            CategoryResource::collection($categories),
            __('api.categories_fetched_successfully')
        );
    }

    public function show($slugOrId): JsonResponse
    {
        // Try to find by slug first, then by ID
        $category = Category::where(function($query) use ($slugOrId) {
            if (is_numeric($slugOrId)) {
                $query->where('id', $slugOrId);
            } else {
                $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$slugOrId])
                      ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.ar')) = ?", [$slugOrId]);
            }
        })->with(['blogs.meta', 'meta'])->first();
        
        if (!$category) {
            return $this->error(
                __('api.category_not_found'),
                404
            );
        }
        
        return $this->success(
            new CategoryResource($category),
            __('api.category_fetched_successfully')
        );
    }
}