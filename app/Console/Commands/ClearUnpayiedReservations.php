<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Reservation\Status;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;

final class ClearUnpayiedReservations extends Command
{
    protected $signature = 'clear-unpayied-reservations';

    protected $description = 'Delete all old and unpayied reservations';

    public function handle()
    {
        $this->info('Start deleting');
        $reservations = Reservation::query()
            ->whereIn('status', [
                Status::Pending,
                Status::PaymentWaiting,
            ])
            ->where('created_at', '<', Carbon::now()->subHours(5))
            ->get();

        foreach ($reservations as $reservation) {
            ReservationRequest::query()
                ->where('reservation_id', $reservation->id)
                ->update([
                    'reservation_id' => null
                ]);
            $reservation->delete();
        }
        $this->info('Finished deleting');
    }
}
