<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property CarbonInterface $resource */
final class DateResource extends JsonResource
{
    /**
     * @return array<string,float|int|string>
     */
    public function toArray(Request $request): array
    {
        return [
            'human' => $this->resource->diffForHumans(),
            'string' => $this->resource->toIso8601String(),
            'timestamp' => $this->resource->timestamp,
        ];
    }
}
