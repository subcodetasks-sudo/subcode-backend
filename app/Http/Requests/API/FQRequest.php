<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class FQRequest extends FormRequest
{
    use ApiResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'question' => 'required|array',
            'question.en' => 'required|string',
            'question.ar' => 'required|string',
            'answer' => 'required|array',
            'answer.en' => 'required|string',
            'answer.ar' => 'required|string',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['question'] = 'sometimes|array';
            $rules['question.en'] = 'sometimes|string';
            $rules['question.ar'] = 'sometimes|string';
            $rules['answer'] = 'sometimes|array';
            $rules['answer.en'] = 'sometimes|string';
            $rules['answer.ar'] = 'sometimes|string';
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
