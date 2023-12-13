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
    protected $signature = 'sync-calendars {apartment_id?}';

    protected $description = 'Sync calendars by ical links';

    public function handle()
    {
        Log::info('Start sync calendars');
        if (!$apartment_id = $this->argument('apartment_id')) {
            $links = ICalLink::all();
            SideReservation::query()
                ->delete();
        } else {
            $links = ICalLink::query()
                ->where('apartment_id', $apartment_id)
                ->get();
            SideReservation::query()
                ->where('apartment_id', $apartment_id)
                ->delete();
        }
        /** @var ICalLink $link */
        foreach ($links as $link) {
            //            try {
            $ical = new ICal();
            $ical->initUrl($link->link);
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
        Log::info('Finish sync calendars');
    }
}
