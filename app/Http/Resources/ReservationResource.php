<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'apartment' => new ApartmentResource($this->resource->apartment?->load('datePrices')),
            'user' => new UserResource($this->resource->user),
            'start' => Carbon::parse($this->resource->start)->format('d.m.Y'),
            'end' => Carbon::parse($this->resource->end)->format('d.m.Y'),
            'guests' => $this->resource->guests,
            'children' => $this->resource->children,
            'range' => $this->resource->range,
            'price' => $this->resource->price,
            'first_payment' => $this->resource->first_payment,
            'status' => $this->resource->status,
            'status_text' => $this->resource->status_text,
            'created_at' => Carbon::parse($this->resource->created_at)->format('d.m.Y H:i'),
            'remaining' => $this->resource->first_payment_until->setTimezone('UTC')->diffInMilliseconds(Carbon::now()),
        ];
    }
}
