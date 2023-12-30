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
            'description' => $this->resource->description,
            'type' => __('instructors.types.' . $this->resource->type->value),
            'created_at' => $this->resource->created_at,
            'avatar' => new ImageResource($this->resource->getFirstMedia('avatar'))
        ];
    }
}
