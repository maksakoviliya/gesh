<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'step' => $this->resource->step,
            'title' => $this->resource->title,
            'status' => $this->resource->status,
            'status_text' => __('statuses.'.$this->resource->status->value),
            'description' => $this->resource->description,
            'address' => $this->resource->address,
            'bedrooms' => $this->resource->bedrooms,
            'lat' => $this->resource->lat,
            'lon' => $this->resource->lon,
            'beds' => $this->resource->beds,
            'bathrooms' => $this->resource->bathrooms,
            'guests' => $this->resource->guests,
            'created_at' => $this->resource->created_at,
            'media' => ImageResource::collection($this->resource->media),
            'weekdays_price' => $this->resource->weekdays_price,
            'weekends_price' => $this->resource->weekends_price,
            'category' => new CategoryResource($this->resource->category),
            'type' => $this->resource->type,
            'features' => FeatureResource::collection($this->resource->features),
            'dates' => DatePriceResource::collection($this->whenLoaded('datePrices')),
            'owner' => new UserResource($this->whenLoaded('user')),
            'fast_reserve' => $this->resource->fast_reserve,
            'all_disabled_dates' => $this->whenAppended('allDisabledDays'),
            'i_cal_links' => ICalLinkResource::collection($this->whenLoaded('ICalLinks')),
        ];
    }
}
