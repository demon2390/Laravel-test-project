<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Check;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use JsonException;
use Throwable;

final class SendPing implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Check $check
    ) {}

    /**
     * @throws JsonException
     */
    public function handle(DatabaseManager $database): void
    {
        $start = now();

        $request = Http::baseUrl($this->check->service->url);

        $request->connectTimeout(3);

        if ($this->check->credential?->metadata) {
            $request->withHeaders($this->check->credential->metadata);
        }

        if ($this->check->parameters) {
            $request->withQueryParameters($this->check->parameters);
        }

        if ($this->check->headers) {
            $request->withHeaders($this->check->headers);
        }

        if ($this->check->body) {
            $request->withBody(json_encode($this->check->body, JSON_THROW_ON_ERROR));
        }

        try {
            $response = $request->send(
                method: $this->check->method,
                url: $this->check->path,
                options: [
                    'json' => $this->check->body,
                ]
            );

            $stats = $response->transferStats;
            if ($stats) {
                $stats = $stats->getHandlerStats();

                $url = Arr::pull($stats, 'url');
                $contentType = Arr::pull($stats, 'content_type');
                $httpCode = Arr::pull($stats, 'http_code');
            }

            $database->transaction(fn () => $this->check->reports()->create([
                'url' => $url ?? null,
                'content_type' => $contentType ?? null,
                'http_code' => $httpCode ?? null,
                'data' => $stats,
                'started_at' => $start,
                'finished_at' => now(),
            ]), 3);
        } catch (Throwable) {
        }
    }
}
