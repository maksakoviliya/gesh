<?php

namespace App\Console\Commands\Apartments;

use App\Models\Apartment;
use Illuminate\Console\Command;

class CheckVisibleUntilCommand extends Command
{
    protected $signature = 'app:check-visible-until-command';

    protected $description = 'Check visible until field in apartments and set it null';

    public function handle(): void
    {
        Apartment::query()
            ->where('visible_until', '<', now())
            ->update(['visible_until' => null]);
    }
}
