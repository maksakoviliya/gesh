<?php

declare(strict_types=1);

namespace App\Http\Resources\Chat;

use App\Http\Resources\ApartmentResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'user' => new UserResource($this->resource->user),
            'apartment' => new ApartmentResource($this->resource->apartment),
            'last_message'=> new MessageResource($this->whenLoaded('last_message'))
        ];
    }
}
