<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ICalLink;
use App\Models\SideReservation;
use Carbon\Carbon;
use ICal\Event;
use ICal\ICal;
use Illuminate\Console\Command;
use Log;

class SyncCalendars extends Command
{
    protected $signature = 'sync-calendars';

    protected $description = 'Sync calendars by ical links';

    public function handle()
    {
        $links = ICalLink::all();
        /** @var ICalLink $link */
        foreach ($links as $link) {
            //            try {
            $ical = new ICal();
            $ical->initUrl($link->link);
            SideReservation::query()
                ->where('apartment_id', $link->apartment_id)
                ->delete();
            /** @var Event $event */
            foreach ($ical->events() as $event) {
                SideReservation::query()
                    ->create([
                        'apartment_id' => $link->apartment_id,
                        'start' => Carbon::parse($event->dtstart),
                        'end' => Carbon::parse($event->dtend),
                        'description' => $event->description,
                        'summary' => $event->summary,
                    ]);
            }
            //            } catch (\Throwable $exception) {
            //                Log::info($exception->getMessage());
            //            }
        }
    }
}
