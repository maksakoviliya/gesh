<?php

declare(strict_types=1);

namespace App\Http\Resources\Instructors;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class InstructorsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'created_at' => $this->resource->created_at,
            'avatar' => new ImageResource($this->resource->getFirstMedia('avatar'))
        ];
    }
}
