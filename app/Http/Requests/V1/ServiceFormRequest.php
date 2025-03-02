<?php

declare(strict_types = 1);

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Tpetry\PostgresqlEnhanced\Query\Builder;

class ServiceFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                $this->route('service') ? 'sometimes' : null,
                'required', 'string', 'min:2', 'max:255',
            ],
            'url'  => [
                $this->route('service') ? 'sometimes' : null,
                'required', 'url', 'min:11', 'max:255',
                Rule::unique('services')->where(
                    fn(Builder $q) => $q
                        ->where('user_id', auth()->id())
                        ->where('url', $this->input('url'))
                        ->orHavingNotNull('deleted_at')
                ),
            ],
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
