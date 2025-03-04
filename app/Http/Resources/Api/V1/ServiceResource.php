<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property Service $resource */
final class ServiceResource extends JsonResource
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'url' => $this->resource->url,
            'created' => new DateResource($this->resource->created_at),
        ];

        return $response;
    }
}
