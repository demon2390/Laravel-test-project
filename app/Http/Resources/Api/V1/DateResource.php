<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api\V1;

use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property CarbonInterface $resource */
class DateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'human'     => $this->resource->diffForHumans(),
            'string'    => $this->resource->toIso8601String(),
            'timestamp' => $this->resource->timestamp,
        ];
    }
}
