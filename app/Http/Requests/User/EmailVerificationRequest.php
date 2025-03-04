<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Auth\EmailVerificationRequest as FormRequest;

final class EmailVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
