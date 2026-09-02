<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use App\Support\UploadLimits;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    use ApiResponse;

    private const MEDIA_MIMES = 'jpeg,png,jpg,gif,webp,mp4,webm,mov,avi,mkv';

    public function index(): JsonResponse
    {
        $testimonials = Testimonial::where('is_active', true)->get();

        return $this->success(
            TestimonialResource::collection($testimonials),
            __('api.testimonials_fetched_successfully')
        );
    }

    public function show($id): JsonResponse
    {
        $testimonial = Testimonial::find($id);

        if (! $testimonial) {
            return $this->error(
                __('api.testimonial_not_found'),
                404
            );
        }

        return $this->success(
            new TestimonialResource($testimonial),
            __('api.testimonial_fetched_successfully')
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'media' => 'required|file|mimes:'.self::MEDIA_MIMES.'|max:'.UploadLimits::maxKb(),
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                422
            );
        }

        $data = $validator->validated();
        $data['media'] = $request->file('media')->store('testimonials', 'public');

        $testimonial = Testimonial::create($data);

        return $this->success(
            new TestimonialResource($testimonial),
            __('api.testimonial_created_successfully'),
            201
        );
    }

    public function update(Request $request, $id): JsonResponse
    {
        $testimonial = Testimonial::find($id);

        if (! $testimonial) {
            return $this->error(
                __('api.testimonial_not_found'),
                404
            );
        }

        $validator = Validator::make($request->all(), [
            'media' => 'sometimes|required|file|mimes:'.self::MEDIA_MIMES.'|max:'.UploadLimits::maxKb(),
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                422
            );
        }

        $data = $validator->validated();

        if ($request->hasFile('media')) {
            if ($testimonial->media && Storage::disk('public')->exists($testimonial->media)) {
                Storage::disk('public')->delete($testimonial->media);
            }

            $data['media'] = $request->file('media')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return $this->success(
            new TestimonialResource($testimonial),
            __('api.testimonial_updated_successfully')
        );
    }

    public function destroy($id): JsonResponse
    {
        $testimonial = Testimonial::find($id);

        if (! $testimonial) {
            return $this->error(
                __('api.testimonial_not_found'),
                404
            );
        }

        if ($testimonial->media && Storage::disk('public')->exists($testimonial->media)) {
            Storage::disk('public')->delete($testimonial->media);
        }

        $testimonial->delete();

        return $this->success(
            [],
            __('api.testimonial_deleted_successfully')
        );
    }
}
