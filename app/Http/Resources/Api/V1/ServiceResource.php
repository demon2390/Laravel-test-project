<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api\V1;

use App\Models\Service;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\Link;

/** @property Service $resource */
class ServiceResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'id'      => $this->resource->id,
            'name'    => $this->resource->name,
            'url'     => $this->resource->url,
            'created' => new DateResource($this->resource->created_at),
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'checks' => fn() => CheckResource::collection($this->whenLoaded('checks')),
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            Link::self(route('v1:services:show', $this->resource)),
        ];
    }
}
