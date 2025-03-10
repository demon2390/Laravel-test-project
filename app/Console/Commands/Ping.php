<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\SendPing;
use App\Models\Check;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'ping',
    description: 'Perform a ping check on registered services.'
)]
final class Ping extends Command
{
    public function handle(): int
    {
        info('Starting to ping services...');

        foreach (Check::query()->cursor() as $check) {
            SendPing::dispatch($check);

            info("Pinging check: {$check->name}");
        }

        return self::SUCCESS;
    }
}
