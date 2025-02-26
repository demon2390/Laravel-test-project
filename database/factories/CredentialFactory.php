<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Enums\CredentialType;
use App\Models\Credential;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

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
            'metadata' => [
                'Authorization-Header' => ($this->faker->boolean() ? CredentialType::Basic_auth->value : CredentialType::Bearer_auth->value) . ' '
                    . $this->faker->uuid(),
            ],
            'user_id'  => User::factory(),
        ];
    }
}
