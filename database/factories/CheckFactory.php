<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Check;
use App\Models\Credential;
use App\Models\Service;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class CheckFactory extends Factory
{
    use HasUlids;

    /** @var class-string<Model> */
    protected $model = Check::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->sentence(),
            'path'          => $this->faker->filePath(),
            'method'        => $this->faker->boolean(80) ? 'GET' : "POST",
            'body'          => null,
            'headers'       => null,
            'parameters'    => null,
            'credential_id' => $this->faker->boolean(20)
                ? Credential::factory()
                : null,
            'service_id'    => Service::factory(),
        ];
    }
}
