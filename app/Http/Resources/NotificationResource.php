<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\ReservationRequest;
use App\Notifications\ReservationRequest\CreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [];
        switch ($this->resource->type) {
            case CreatedNotification::class:
                $data['reservation_request'] = new ReservationRequestResource(ReservationRequest::find($this->resource->data['reservation_request_id']));
        }

        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'title' => __('notifications.' . $this->resource->type),
            'data' => $data,
            'created_at' => $this->resource->created_at->format('d.m.Y H:i'),
            'read_at' => $this->resource->read_at,
        ];
    }
}
