<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'description.ar' => 'required|string',
            'caption' => 'nullable|array',
            'caption.en' => 'nullable|string',
            'caption.ar' => 'nullable|string',
            'long_description' => 'nullable|array',
            'long_description.en' => 'nullable|string',
            'long_description.ar' => 'nullable|string',
            'technologies' => 'nullable|array',
            'technologies.en' => 'nullable|array',
            'technologies.ar' => 'nullable|array',
            'department_id' => 'required|exists:departments,id',
            'image' => 'nullable|string',
            'main_image' => 'nullable|string',
            'images' => 'nullable|array',
            'link_project' => 'nullable|url',
            'status' => 'nullable|boolean',
            'tags' => 'nullable|array',
        ];

        // For updates, make required fields optional
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'sometimes|array';
            $rules['name.en'] = 'sometimes|string|max:255';
            $rules['name.ar'] = 'sometimes|string|max:255';
            $rules['description'] = 'sometimes|array';
            $rules['description.en'] = 'sometimes|string';
            $rules['description.ar'] = 'sometimes|string';
            $rules['department_id'] = 'sometimes|exists:departments,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.en.required' => 'English name is required',
            'name.ar.required' => 'Arabic name is required',
            'description.required' => 'Description is required',
            'description.en.required' => 'English description is required',
            'description.ar.required' => 'Arabic description is required',
            'department_id.required' => 'Department is required',
            'department_id.exists' => 'Selected department does not exist',
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
