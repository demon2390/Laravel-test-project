<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

final class ServiceFormRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                $this->route('service') ? 'sometimes' : null,
                'required', 'string', 'min:2', 'max:255',
            ],
            'url' => [
                $this->route('service') ? 'sometimes' : null,
                'required', 'url', 'min:11', 'max:255',
                Rule::unique('services')->where(
                    fn (Builder $q) => $q
                        ->where('user_id', Auth::id())
                        ->where('url', $this->input('url'))
                        ->orHavingNotNull('deleted_at')
                ),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'url' => 'The url has already been taken in another your service OR haven`t schema',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        abort(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            __('v1.failure.data', ['error' => $validator->errors()->first()]), // @phpstan-ignore-line
        );
    }
}
