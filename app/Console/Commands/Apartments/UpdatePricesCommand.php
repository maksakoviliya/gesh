<?php

namespace App\Console\Commands\Apartments;

use App\Actions\Apartments\UpdatePricesPercentsAction;
use App\Models\Apartment;
use Illuminate\Console\Command;

class UpdatePricesCommand extends Command
{
    protected $signature = 'app:update-prices-command {--id=}';

    protected $description = 'Command updates prices';

    public function handle()
    {
        $id = $this->option('id');
        if ($id) {
            $apartments = Apartment::query()
                ->where('id', $id);
        } else {
            $apartments = Apartment::query()
                ->get();
        }

        $from = $this->ask('Current percents: ', 15);
        $to = $this->ask('New percents: ', 17.6);
        $action = new UpdatePricesPercentsAction;

        foreach ($apartments as $apartment) {
            $action->run($apartment, $from, $to);
        }
    }
}
