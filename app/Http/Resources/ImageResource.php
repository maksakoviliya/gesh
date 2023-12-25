<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->uuid,
            'src' => $this->resource->getFullUrl(),
            'srcset' => $this->resource->getSrcset(),
            'order' => $this->resource->order_column,
        ];
    }
}
