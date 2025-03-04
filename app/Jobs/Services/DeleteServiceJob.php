<?php

declare(strict_types=1);

namespace App\Jobs\Services;

use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

final class DeleteServiceJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Service $service,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(DatabaseManager $databaseManager): void
    {
        $databaseManager->transaction(
            callback: fn () => $this->service->delete(),
            attempts: 3
        );
    }
}
