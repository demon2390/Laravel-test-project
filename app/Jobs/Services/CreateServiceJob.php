<?php

declare(strict_types = 1);

namespace App\Jobs\Services;

use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class CreateServiceJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly array $data
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(DatabaseManager $databaseManager): void
    {
        $databaseManager->transaction(
            callback: fn() => Service::query()->create(
                attributes: $this->data
            ),
            attempts: 3
        );
    }
}
