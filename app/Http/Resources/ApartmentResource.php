<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ApartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'is_visible' => $this->resource->isVisible,
            'step' => $this->resource->step,
            'title' => $this->resource->title,
            'status' => $this->resource->status,
            'status_text' => __('statuses.'.$this->resource->status->value),
            'description' => Str::replace('&nbsp;', ' ', $this->resource->description),
            'address' => $this->resource->fullAddress,
            'bedrooms' => $this->resource->bedrooms,
            'lat' => $this->resource->lat,
            'lon' => $this->resource->lon,
            'state' => $this->resource->state,
            'city' => $this->resource->city,
            'street' => $this->resource->street,
            'building' => $this->resource->building,
            'housing' => $this->resource->housing,
            'room' => $this->resource->room,
            'floor' => $this->resource->floor,
            'entrance' => $this->resource->entrance,
            'beds' => $this->resource->beds,
            'bathrooms' => $this->resource->bathrooms,
            'guests' => $this->resource->guests,
            'is_verified' => $this->resource->is_verified,
            'created_at' => $this->resource->created_at,
            'thumb' => $this->resource->getFirstMedia(),
            'media' => ImageResource::collection($this->resource->getMedia()),
            'weekdays_price' => $this->resource->weekdays_price,
            'weekends_price' => $this->resource->weekends_price,
            'base_weekdays_price' => $this->when(
                $this->resource->user_id === Auth::id(),
                $this->resource->base_weekdays_price
            ),
            'base_weekends_price' => $this->when(
                $this->resource->user_id === Auth::id(),
                $this->resource->base_weekends_price
            ),
            'category' => new CategoryResource($this->resource->category),
            'type' => $this->resource->type,
            'features' => FeatureResource::collection($this->resource->features),
            'dates' => DatePriceResource::collection($this->whenLoaded('datePrices')),
            'owner' => new UserResource($this->whenLoaded('user')),
            'fast_reserve' => $this->resource->fast_reserve,
            'all_disabled_dates' => $this->whenAppended('allDisabledDays'),
            'i_cal_links' => ICalLinkResource::collection($this->whenLoaded('ICalLinks')),
            'total_price' => $this->getTotalPriceForPeriod($request),
            'avito_id' => $this->resource->avito_id,
            'avito_synced_at' => $this->resource?->avito_synced_at?->format('d.m.Y H:i'),
            'views' => $this->resource->views,
        ];
    }

    public function getTotalPriceForPeriod(Request $request)
    {
        if (! $request->input('start') && ! $request->input('end')) {
            return null;
        }
        $start = Carbon::createFromFormat('d_m_Y', $request->input('start'));
        $end = Carbon::createFromFormat('d_m_Y', $request->input('end'));

        return $this->resource->getPriceForRange($start, $end);
    }
}
