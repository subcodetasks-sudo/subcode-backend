<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class SettingRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'site_name' => 'sometimes|string|max:255',
            'site_logo' => 'sometimes|string',
            'site_favicon' => 'sometimes|string',
            'site_description' => 'sometimes|string',
            'site_email' => 'sometimes|email',
            'site_phone' => 'sometimes|string',
            'site_address' => 'sometimes|string',
            'facebook' => 'sometimes|url|nullable',
            'twitter' => 'sometimes|url|nullable',
            'instagram' => 'sometimes|url|nullable',
            'linkedin' => 'sometimes|url|nullable',
            'youtube' => 'sometimes|url|nullable',
            'tiktok' => 'sometimes|url|nullable',
            'snapchat' => 'sometimes|url|nullable',
            'pinterest' => 'sometimes|url|nullable',
            'whatsapp' => 'sometimes|string|nullable',
            'telegram' => 'sometimes|string|nullable',
            'terms_conditions' => 'sometimes|string|nullable',
            'privacy_policy' => 'sometimes|string|nullable',
            'refund_policy' => 'sometimes|string|nullable',
            'about_us' => 'sometimes|string|nullable',
            'contact_info' => 'sometimes|string|nullable',
            'meta_keywords' => 'sometimes|string|nullable',
            'meta_description' => 'sometimes|string|nullable',
            'google_analytics' => 'sometimes|string|nullable',
            'facebook_pixel' => 'sometimes|string|nullable',
            'currency' => 'sometimes|string',
            'timezone' => 'sometimes|string',
            'language' => 'sometimes|string',
            'maintenance_mode' => 'sometimes|boolean',
        ];

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
