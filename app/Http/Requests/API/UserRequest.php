<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class UserRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($userId ? ",$userId" : ''),
            'mobile' => 'required|string|unique:users,mobile' . ($userId ? ",$userId" : ''),
            'password' => 'required|min:8|confirmed',
            'image' => 'nullable|string',
        ];

        // For updates, make some fields optional and handle password separately
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'sometimes|string|max:255';
            $rules['email'] = 'sometimes|email|unique:users,email' . ($userId ? ",$userId" : '');
            $rules['mobile'] = 'sometimes|string|unique:users,mobile' . ($userId ? ",$userId" : '');
            $rules['password'] = 'sometimes|min:8|confirmed';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already taken',
            'mobile.required' => 'Mobile number is required',
            'mobile.unique' => 'This mobile number is already taken',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
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
