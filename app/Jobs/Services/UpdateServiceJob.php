<?php

declare(strict_types=1);

namespace App\Jobs\Services;

use App\Models\Service;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

final class UpdateServiceJob implements ShouldQueue
{
    use Queueable;

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(
        public readonly array $data,
        public readonly Service $service,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(DatabaseManager $databaseManager): void
    {
        $databaseManager->transaction(
            callback: fn () => $this->service->update(
                attributes: $this->data
            ),
            attempts: 3
        );
    }
}
