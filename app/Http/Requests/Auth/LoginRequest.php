<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    
        public function rules(): array
        {
            return [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ];
        }

        public function messages(): array
        {
            return [
                'email.required' => __('validation.email_required'),
                'email.email' => __('validation.email_invalid'),
                'password.required' => __('validation.password_required'),
            ];
        }
    }

 
