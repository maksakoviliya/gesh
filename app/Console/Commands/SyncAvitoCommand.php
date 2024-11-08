<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Apartments\Status;
use App\Models\Apartment;
use App\Services\AvitoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

final class SyncAvitoCommand extends Command
{
    protected $signature = 'app:sync-avito-command {apartment_id?}';

    protected $description = 'Sync all users with avito';

    public function __construct(
        protected AvitoService $avitoService
    )
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('Start sync avito');
        if (!$apartment_id = $this->argument('apartment_id')) {
            $apartments = Apartment::query()
                ->where('status', Status::Published->value)
                ->select(['id', 'user_id', 'avito_id'])
                ->with('user')
                ->without('media')
                ->whereNotNull('avito_id')
                ->get();
        } else {
            $apartments = Apartment::query()
                ->where('status', Status::Published->value)
                ->select(['id', 'user_id', 'avito_id'])
                ->with('user')
                ->without('media')
                ->where('apartment_id', $apartment_id)
                ->whereNotNull('avito_id')
                ->get();
        }

        if (!count($apartments)) {
            Log::info('No avito ids provided');
            return parent::SUCCESS;
        }

        Log::info('----------------------');
        foreach ($apartments as $apartment) {
            try {
                Log::info($apartment->id);
                $this->avitoService->syncDates($apartment);
                Log::info('----------------------');
            } catch (Throwable $exception) {
                Log::error($exception->getMessage());
            }
        }
    }
}
