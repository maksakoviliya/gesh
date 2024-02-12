<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apartments = Apartment::query()
            ->whereHas('disabledDates')
            ->get();
        foreach ($apartments as $apartment) {
            $segments = [];
            $dates = $apartment->disabledDates()->orderBy('date')->get();

            $start = null;
            $end = null;

            foreach ($dates as $date) {
                if ($start === null) {
                    $start = $date->date->startOfDay()->hours(15);
                } elseif ($end->diff($date->date->startOfDay())->days > 1) {
                    $segments[] = [
                        $start->format('d.m.Y H:i:s'),
                        $end->addDay()->format('d.m.Y H:i:s')
                    ];
                    $start = $date->date->startOfDay()->hours(15);
                }
                $end = $date->date->startOfDay()->hours(12);
            }
            $segments[] = [$start->format('d.m.Y H:i:s'), $end->format('d.m.Y H:i:s')];
            dd($segments);
        }
    }
}
