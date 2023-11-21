<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'step' => $this->resource->step,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'address' => $this->resource->address,
            'bedrooms' => $this->resource->bedrooms,
            'guests' => $this->resource->guests,
            'created_at' => $this->resource->created_at,
            'images' => ImageResource::collection($this->resource->media),
            'price' => $this->resource->price,
            'categories' => CategoryResource::collection($this->resource->categories),
        ];
    }
}
