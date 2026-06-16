<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class BlogRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'auther_id' => 'nullable|exists:admins,id',
            'image' => 'nullable|string',
            'image_alt' => 'nullable|array',
            'image_alt.en' => 'nullable|string|max:255',
            'image_alt.ar' => 'nullable|string|max:255',
            'image_alt.tr' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
            'time_publish' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'meta' => 'nullable|array',
            'meta.meta_title' => 'nullable|array',
            'meta.meta_description' => 'nullable|array',
        ];

        // For updates, make title and description optional
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['title'] = 'sometimes|array';
            $rules['title.en'] = 'sometimes|string|max:255';
            $rules['title.ar'] = 'sometimes|string|max:255';
            $rules['description'] = 'sometimes|array';
            $rules['description.en'] = 'sometimes|string';
            $rules['description.ar'] = 'sometimes|string';
            $rules['category_id'] = 'sometimes|exists:categories,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.en.required' => 'English title is required',
            'title.ar.required' => 'Arabic title is required',
            'description.required' => 'Description is required',
            'description.en.required' => 'English description is required',
            'description.ar.required' => 'Arabic description is required',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Selected category does not exist',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
