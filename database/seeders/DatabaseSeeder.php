<?php

namespace Database\Seeders;

use App\Models\Check;
use App\Models\Service;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()
            ->count(3)
            ->has(
                Service::factory()
                    ->count(3)
                    ->has(
                        Check::factory()
                            ->count(3)
                    )
            )
            ->create();
/*
        $services = Service::factory()
            ->for($users)
//            ->count(2)
            ->create();

        $checks = Check::factory()
            ->for($services)
            ->count(10)
            ->create();*/
    }
}
