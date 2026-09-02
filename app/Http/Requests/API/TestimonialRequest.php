<?php

namespace App\Http\Requests\API;

use App\Support\UploadLimits;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class TestimonialRequest extends FormRequest
{
    use ApiResponse;

    private const MEDIA_MIMES = 'jpeg,png,jpg,gif,webp,mp4,webm,mov,avi,mkv';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'media' => 'required|file|mimes:'.self::MEDIA_MIMES.'|max:'.UploadLimits::maxKb(),
            'is_active' => 'nullable|boolean',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['media'] = 'sometimes|required|file|mimes:'.self::MEDIA_MIMES.'|max:'.UploadLimits::maxKb();
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
