<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class TestimonialRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'comment' => 'required|array',
            'comment.en' => 'required|string',
            'comment.ar' => 'required|string',
            'image' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'nullable|boolean',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'sometimes|string|max:255';
            $rules['comment'] = 'sometimes|array';
            $rules['comment.en'] = 'sometimes|string';
            $rules['comment.ar'] = 'sometimes|string';
            $rules['rating'] = 'sometimes|integer|min:1|max:5';
        }

        return $rules;
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
