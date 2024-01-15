<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Chat\Chat;
use App\Models\ReservationRequest;
use App\Notifications\ReservationRequest\CreatedNotification;
use App\Notifications\Telegram\NewTelegramAuthCodeGeneratedNotification;
use Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [];
        switch ($this->resource->type) {
            case CreatedNotification::class:
                $reservation_request = ReservationRequest::find($this->resource->data['reservation_request_id']);
                $chat = Chat::query()
                    ->where('apartment_id', $reservation_request?->apartment_id)
                    ->where('user_id', $reservation_request?->user?->id)
                    ->first();
                $data['reservation_request'] = new ReservationRequestResource($reservation_request);
                $data['chat_id'] = $chat?->id;
                break;
            case NewTelegramAuthCodeGeneratedNotification::class:
                $data['code'] = Arr::get($this->resource->data, 'code');
                break;
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
