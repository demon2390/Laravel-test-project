<?php

declare(strict_types = 1);

namespace App\Http\Requests\V1\Services;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|min:2|max:255',
            'url'  => 'sometimes|url|min:11|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        abort(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            __('v1.failure.data', ['error' => $validator->errors()->first()]),
        );
    }
}
