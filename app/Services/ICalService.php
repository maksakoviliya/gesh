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

            $processed = [];

            /** @var Event $event */
            foreach ($ical->events() as $event) {
                if (Carbon::parse($event->dtstart) < now()->subMonth()) {
                    continue;
                }
                Log::info("Process for apartment: $apartment->id.");
                $sideReservation = SideReservation::query()->firstOrCreate([
                    'apartment_id' => $apartment->id,
                    'start' => Carbon::parse($event->dtstart)->setTime(15, 0),
                    'end' => Carbon::parse($event->dtend)->setTime(12, 0),
                    'description' => $event->description,
                    'summary' => $event->summary,
                ]);
                $processed[] = $sideReservation->id;
            }

            Log::info("Processed: " . json_encode($processed));

            SideReservation::query()
                ->whereNotIn('id', $processed)
                ->delete();
        } catch (Throwable $exception) {
            Log::error($exception->getMessage());
        }
    }
}
