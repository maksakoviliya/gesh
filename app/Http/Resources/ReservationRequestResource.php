<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'apartment' => new ApartmentResource($this->resource->apartment),
            'user' => new UserResource($this->resource->user),
            'start' => Carbon::parse($this->resource->start)->format('d.m.Y'),
            'end' => Carbon::parse($this->resource->end)->format('d.m.Y'),
            'guests' => $this->resource->guests,
            'children' => $this->resource->children,
            'range' => $this->resource->range,
            'price' => $this->resource->price,
            'status' => $this->resource->status,
            'status_text' => $this->resource->status_text,
            'created_at' => Carbon::parse($this->resource->created_at)->format('d.m.Y H:i')
        ];
    }
}
