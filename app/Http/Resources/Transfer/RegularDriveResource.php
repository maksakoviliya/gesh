<?php

declare(strict_types=1);

namespace App\Http\Resources\Transfer;

use App\Services\Transfer\RegularDriveService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class RegularDriveResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $regularDriveService = new RegularDriveService;

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'price' => $this->resource->regular_price,
            'price_formatted' => Number::currency($this->resource->regular_price, 'RUB', 'ru'),
            'img' => $this->resource->getFirstMediaUrl('banner'),
            'dates' => $regularDriveService->getAvailableSeats($this->resource),
            'start_point' => $this->resource->start_point,
            'finish_point' => $this->resource->finish_point,
            'start_at' => $this->resource->start_at->format('h:i'),
            'duration' => intval($this->resource->duration / 60),
            'passengers_limit' => $this->resource->passengers_limit,
        ];
    }
}
