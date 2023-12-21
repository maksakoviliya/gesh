<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'avatar' => $this->resource->avatar,
            'created_at' => $this->resource->created_at->format('d.m.Y'),
            'since' => $this->resource->created_at->diffForHumans(
                null,
                CarbonInterface::DIFF_ABSOLUTE,
                true
            ),
            'is_admin' => $this->resource->hasRole('admin'),
        ];
    }
}
