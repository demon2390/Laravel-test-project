<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Credential;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CredentialFactory extends Factory
{
    use HasUlids;

    /** @var class-string<Model> */
    protected $model = Credential::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name'     => $this->faker->sentence(),
            'metadata' => null,
            'value'    => Str::random(),
            'user_id'  => User::factory(),
        ];
    }
}
