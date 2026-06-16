<?php

namespace App\Http\Requests\profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'new_password' => [
                'required',
                'string',
                'confirmed',
                'different:current_password',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'new_password_confirmation' => ['required', 'string'],
            'logout_other_devices' => ['sometimes', 'boolean']
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'current_password' => __('validation.attributes.current_password'),
            'new_password' => __('validation.attributes.new_password'),
            'new_password_confirmation' => __('validation.attributes.new_password_confirmation'),
            'logout_other_devices' => __('validation.attributes.logout_other_devices'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'current_password.current_password' => __('validation.current_password_incorrect'),
            'new_password.different' => __('validation.new_password_different'),
            'new_password.confirmed' => __('validation.password_confirmation'),
        ];
    }
}
