<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Visitor;
use App\Models\Website;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\WebsiteResource;
use App\Enum\VisitorTypeEnum;
use App\Http\Resources\LiteWebsiteResource;

class WebsiteController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'department_id' => 'sometimes|integer|exists:departments,id',
        ]);
        
        $websites = Website::withoutGlobalScopes()
    ->with(['department', 'advantageWebsites', 'reviewWebsites', 'subscriptions', 'meta'])
    ->when($request->department_id, fn($q) => $q->where('department_id', $request->department_id))
    ->where('status', 1)
    ->paginate(15);


        return $this->PaginationResponse(
           LiteWebsiteResource::collection($websites),
            __('api.websites_fetched_successfully')
        );
    }
    public function show(Request $request, $slug): JsonResponse
    {
          $lang = app()->getLocale();
        $website = Website::with(['department', 'advantageWebsites', 'reviewWebsites', 'subscriptions', 'meta'])
            ->where("slug->{$lang}", $slug)
            ->where('status', 1)
            ->first();

        if (!$website) {
            return $this->error(
                __('api.website_not_found'),
                404
            );
        }

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $visitor = Visitor::where('ip', $ip)
            ->where('user_agent', $userAgent)
            ->where('type', VisitorTypeEnum::WEBSITE->value)
            ->where('visitable_id', $website->id)
            ->where('visitable_type', Website::class)
            ->first();

        if ($visitor) {
            $visitor->increment('hits');
            $visitor->update(['last_seen' => now()]);
        } else {
            Visitor::create([
                'ip' => $ip,
                'user_agent' => $userAgent,
                'first_seen' => now(),
                'last_seen' => now(),
                'type' => VisitorTypeEnum::WEBSITE->value,
                'visitable_id' => $website->id,
                'visitable_type' => Website::class,
            ]);
        }

        $views_count = $website->visitors()->count();

        return $this->success(
            [
                'website' => new WebsiteResource($website),
                'views_count' => $views_count,
            ],
            __('api.website_fetched_successfully')
        );
    }
}
