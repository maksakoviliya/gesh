<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @var bool
     */
    private mixed $showContacts;

    public function __construct(mixed $resource, bool $showContacts = false)
    {
        parent::__construct($resource);
        $this->showContacts = $showContacts;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'avatar' => $this->resource->avatar,
            'created_at' => $this->resource->created_at->format('d.m.Y'),
            'since' => $this->resource->created_at->diffForHumans(
                null,
                CarbonInterface::DIFF_ABSOLUTE,
                true
            ),
            'email' => $this->when($this->showContacts, $this->resource->email),
            'phone' => $this->when($this->showContacts, $this->resource->phone),
            'can_view_dashboard' => $this->resource->hasRole(['admin', 'moderator']),
        ];
    }
}
