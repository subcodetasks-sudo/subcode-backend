<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of testimonials.
     */
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::where('is_active', true)->get();
        
        return $this->success(
            TestimonialResource::collection($testimonials),
            __('api.testimonials_fetched_successfully')
        );
    }

    /**
     * Display the specified testimonial.
     */
    public function show($id): JsonResponse
    {
        $testimonial = Testimonial::find($id);
        
        if (!$testimonial) {
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

    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'description' => 'required|string',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                422
            );
        }

        $data = $validator->validated();

        // Handle client image upload
        if ($request->hasFile('client_image')) {
            $data['client_image'] = $request->file('client_image')->store('testimonials/clients', 'public');
        }

        // Handle project image upload
        if ($request->hasFile('project_image')) {
            $data['project_image'] = $request->file('project_image')->store('testimonials/projects', 'public');
        }

        $testimonial = Testimonial::create($data);

        return $this->success(
            new TestimonialResource($testimonial),
            __('api.testimonial_created_successfully'),
            201
        );
    }

    /**
     * Update the specified testimonial.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $testimonial = Testimonial::find($id);
        
        if (!$testimonial) {
            return $this->error(
                __('api.testimonial_not_found'),
                404
            );
        }

        $validator = Validator::make($request->all(), [
            'client_name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_name' => 'sometimes|required|string|max:255',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                422
            );
        }

        $data = $validator->validated();

        // Handle client image upload
        if ($request->hasFile('client_image')) {
            // Delete old client image
            if ($testimonial->client_image && Storage::disk('public')->exists($testimonial->client_image)) {
                Storage::disk('public')->delete($testimonial->client_image);
            }
            $data['client_image'] = $request->file('client_image')->store('testimonials/clients', 'public');
        }

        // Handle project image upload
        if ($request->hasFile('project_image')) {
            // Delete old project image
            if ($testimonial->project_image && Storage::disk('public')->exists($testimonial->project_image)) {
                Storage::disk('public')->delete($testimonial->project_image);
            }
            $data['project_image'] = $request->file('project_image')->store('testimonials/projects', 'public');
        }

        $testimonial->update($data);

        return $this->success(
            new TestimonialResource($testimonial),
            __('api.testimonial_updated_successfully')
        );
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy($id): JsonResponse
    {
        $testimonial = Testimonial::find($id);
        
        if (!$testimonial) {
            return $this->error(
                __('api.testimonial_not_found'),
                404
            );
        }

        // Delete client image if exists
        if ($testimonial->client_image && Storage::disk('public')->exists($testimonial->client_image)) {
            Storage::disk('public')->delete($testimonial->client_image);
        }

        // Delete project image if exists
        if ($testimonial->project_image && Storage::disk('public')->exists($testimonial->project_image)) {
            Storage::disk('public')->delete($testimonial->project_image);
        }

        $testimonial->delete();

        return $this->success(
            [],
            __('api.testimonial_deleted_successfully')
        );
    }
}