<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Check;
use App\Models\Report;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()
            ->create([
                'name' => 'Test User',
                'email' => 'example@email.test',
            ]);

        event(new Registered($user));

        Service::factory()
            ->for($user)
            ->create([
                'name' => 'Localhost',
                'url' => 'http://localhost/',
            ]);

        $service = Service::factory()
            ->for($user)
            ->create([
                'name' => 'Test Service',
                'url' => 'https://google.com/',
            ]);

        Check::factory()
            ->for($service)
            ->create([
                'name' => 'Google main page',
                'path' => '/',
                'method' => 'get',
                'headers' => [
                    'User-Agent' => 'Laravel Portfolio',
                ],
            ]);

        // and others
        User::factory()->has(
            Service::factory()->count(2)->has(
                Check::factory()->count(2)->has(
                    Report::factory()->count(2)
                )
            )
        )
            ->count(2)
            ->create();
    }
}
