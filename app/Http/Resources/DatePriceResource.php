<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatePriceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->resource->date,
            'price' => $this->resource->price,
        ];
    }
}
