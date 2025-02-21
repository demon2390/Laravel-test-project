<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api\V1;

use App\Models\Check;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

/** @property Check $resource */
class CheckResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'path' => $this->resource->path,
        ];
    }
}
