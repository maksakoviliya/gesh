<?php

declare(strict_types=1);

namespace App\Actions\Apartments;

use App\Enums\LogEvents\NamesEnum;
use App\Models\Apartment;
use App\Services\LogService;
use Auth;
use Carbon\Carbon;

final class SetLastReviewAtAction
{
    public function __construct(
        private LogService $logService
    ) {}

    public function call(Apartment $apartment): void
    {
        $oldLastReviewAt = $apartment->last_review_at;
        $newLastReviewAt = Carbon::now();
        $apartment->update(['last_review_at' => $newLastReviewAt]);
        $this->logService->writeEvent(
            Auth::user(),
            name: NamesEnum::SET_LAST_REVIEWED_AT,
            data_before: [
                'last_review_at' => $oldLastReviewAt,
            ],
            data_after: [
                'last_review_at' => $newLastReviewAt,
            ],
            eventable_type: Apartment::class,
            eventable_id: $apartment->id
        );
    }
}
