<?php

declare(strict_types=1);

namespace App\Http\Resources\Transfer\RegularDrive;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class ShortRegularDriveResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'img' => $this->resource->getFirstMediaUrl('banner', 'responsive'),
            'price' => Number::currency($this->resource->regular_price, 'RUB', 'ru'),
        ];
    }
}
