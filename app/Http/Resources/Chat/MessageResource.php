<?php

declare(strict_types=1);

namespace App\Http\Resources\Chat;

use App\Http\Resources\ReservationRequestResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user' => new UserResource($this->resource->user),
            'message' => $this->resource->message,
            'created_at' => Carbon::parse($this->resource->created_at)->format('d.m.Y H:i'),
            'reservation_request' => new ReservationRequestResource($this->resource->reservation_request?->load('reservation')),
        ];
    }
}
