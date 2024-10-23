<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\ICalLink;
use App\Models\SideReservation;
use App\Services\ICalService;
use Illuminate\Console\Command;
use Log;

final class SyncCalendars extends Command
{
    protected $signature = 'sync-calendars {apartment_id?}';

    protected $description = 'Sync calendars by ical links';

    public function __construct(
        protected ICalService $iCalService
    ) {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Start sync calendars');
        if (! $apartment_id = $this->argument('apartment_id')) {
            $links = ICalLink::has('apartment')->get();
        } else {
            $links = ICalLink::query()
                ->where('apartment_id', $apartment_id)
                ->get();
        }

        $progressBar = $this->output->createProgressBar($links->count());

        /** @var ICalLink $link */
        foreach ($links as $link) {
            $this->iCalService->process($link->link, $link->apartment);
            $progressBar->advance();
        }

        Log::info('Finish sync calendars');
        $progressBar->finish();
    }
}
