<?php

namespace Database\Seeders;

use App\Models\Check;
use App\Models\Report;
use App\Models\Service;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()
            ->create([
                'name'  => 'Test User',
                'email' => 'example@email.test',
            ]);

        $service = Service::factory()
            ->for($user)
            ->create([
                'name' => 'Test Service',
                'url'  => 'https://google.com/',
            ]);

        Check::factory()
            ->for($service)
            ->create([
                'name'    => 'root check',
                'path'    => '/',
                'method'  => 'get',
                'headers' => [
                    'User-Agent' => 'Laravel Portfolio',
                ],
            ]);

        // and others
        User::factory()->has(
            Service::factory()->count(3)->has(
                Check::factory()->count(3)->has(
                    Report::factory()->count(3)
                )
            )
        )
            ->count(3)
            ->create();
    }
}
