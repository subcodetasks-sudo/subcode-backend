<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    use ApiResponse;

    public function index()
    {

        // $blogs = $this->getPublishedOrScheduledBlogs();

        $blogs = Blog::with(['category', 'meta'])
            ->where('is_active', 1)
            ->where('status', 'publish')
            ->latest()
            ->paginate(15);

        if ($blogs->isEmpty()) {
            return $this->success(
                [],
                __('api.blog_not_found')
            );
        }

        return $this->PaginationResponse(
            BlogResource::collection($blogs),
            __('api.retrieve_blog')
        );
    }

    public function show($slugOrId)
    {
        $blog = Blog::with(['category', 'meta'])->findBySlugOrId($slugOrId);

        if (! $blog) {
            return $this->error(
                __('api.blog_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->success([
            'blog' => new BlogResource($blog),
        ], __('api.blog_fetched_successfully'));
    }

    public function blogs(Request $request)
    {
        $blogs = $this->getPublishedOrScheduledBlogs();

        if ($blogs->isEmpty()) {
            return $this->success(
                [],
                __('api.blog_not_found')
            );
        }

        return $this->PaginationResponse(
            $blogs->setCollection(BlogResource::collection($blogs->getCollection())),
            __('api.retrieve_blog')
        );
    }

    private function getPublishedOrScheduledBlogs()
    {
        $timeNow = now()->setTimezone(config('app.timezone'))->toDateTimeString();

        return Blog::with(['category', 'meta', 'admins'])->where(function ($query) use ($timeNow) {
            $query->where(function ($q) {
                $q->where('status', 'publish')
                    ->where('is_active', 1);
            })->orWhere(function ($q) use ($timeNow) {
                $q->where('status', 'schedule')
                    ->where('time_publish', '<=', $timeNow)
                    ->where('is_active', 1);
            });
        })
            ->latest()
            ->paginate(6);
    }

    public function singleBlog($slugOrId)
    {
        $blog = Blog::with(['category', 'meta'])->findBySlugOrId($slugOrId);

        if (! $blog) {
            return $this->error(
                __('api.blog_not_found'),
                404
            );
        }

        $alsoLike = Blog::query()
            ->where('is_active', 1)
            ->where('status', 'publish')
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->inRandomOrder()
            ->take(3)
            ->get(['id', 'title', 'description', 'slug', 'image', 'created_at'])
            ->map(fn (Blog $related) => [
                'id' => $related->id,
                'title' => $related->title,
                'description' => $related->description,
                'slug' => $related->slug,
                'image' => $related->image ? url("storage/{$related->image}") : null,
                'created_at' => $related->created_at,
            ]);

        $blogPayload = (new BlogResource($blog))->toArray(request());
        $blogPayload['also_like'] = $alsoLike;

        return $this->success([
            'blog' => $blogPayload,
        ], __('api.retrieve_blog'));
    }

    public function search(Request $request)
    {
        $blogs = $this->searchBlogQuery($request);

        if ($blogs->isEmpty()) {
            return $this->success(
                [],
                __('api.blog_not_found')
            );
        }

        return $this->success(
            BlogResource::collection($blogs),
            __('api.retrieve_blog')
        );
    }

    private function searchBlogQuery(Request $request)
    {
        $search = $request->input('search');

        return Blog::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })
            ->with(['category', 'meta'])
            ->get();
    }

    public function categoryWithBlog()
    {
        $categories = Category::with([
            'meta',
            'blogs' => fn ($query) => $query
                ->where('is_active', 1)
                ->where('status', 'publish'),
            'blogs.meta',
            'blogs.category',
        ])->get();

        if ($categories->isEmpty()) {
            return $this->success(
                [],
                __('api.data_is_empty')
            );
        }

        $data = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image' => $category->image ? url("storage/{$category->image}") : null,
                'blogs' => BlogResource::collection($category->blogs),
            ];
        });

        return $this->success(
            $data,
            __('api.retrieve_categories')
        );
    }

    public function filterCategory($id)
    {
        $category = Category::with([
            'meta',
            'blogs' => fn ($query) => $query
                ->where('is_active', 1)
                ->where('status', 'publish'),
            'blogs.meta',
            'blogs.category',
        ])->find($id);

        if (! $category) {
            return $this->error(
                __('api.category_not_found'),
                404
            );
        }

        if ($category->blogs->isEmpty()) {
            return $this->success(
                [],
                __('api.data_is_empty')
            );
        }

        $data = [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'title' => $category->title,
                'slug' => $category->slug,
                'image' => $category->image ? url("storage/{$category->image}") : null,
            ],
            'blogs' => BlogResource::collection($category->blogs),
        ];

        return $this->success(
            $data,
            __('api.retrieve_categories')
        );
    }
}
