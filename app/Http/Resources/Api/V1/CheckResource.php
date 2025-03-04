<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Models\Check;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property Check $resource */
final class CheckResource extends JsonResource
{
    /**
     * @return array<string,string>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'path' => $this->resource->path,
        ];
    }
}
