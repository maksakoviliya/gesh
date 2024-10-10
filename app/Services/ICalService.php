<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Apartment;
use App\Models\SideReservation;
use Carbon\Carbon;
use ICal\Event;
use ICal\ICal;
use Illuminate\Support\Facades\Log;
use Throwable;

final class ICalService
{
    public function process(string $url, Apartment $apartment): void
    {
        try {
            $ical = new ICal();
            $ical->initUrl($url);

            /** @var Event $event */
            foreach ($ical->events() as $event) {
                SideReservation::query()
                    ->create([
                        'apartment_id' => $apartment->id,
                        'start' => Carbon::parse($event->dtstart)->setTime(15, 0),
                        'end' => Carbon::parse($event->dtend)->setTime(12, 0),
                        'description' => $event->description,
                        'summary' => $event->summary,
                    ]);
            }
        } catch (Throwable $exception) {
            Log::info($exception->getMessage());
        }
    }
}
