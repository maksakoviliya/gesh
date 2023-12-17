<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'type' => $this->resource->type,
            'title' => __('notifications.' . $this->resource->type),
            'data' => $this->resource->data,
            'created_at' => $this->resource->created_at,
            'read_at' => $this->resource->read_at,
        ];
    }
}
