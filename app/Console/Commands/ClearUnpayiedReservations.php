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
    protected $signature = 'clear-unpayied-reservations {--A|all}';

    protected $description = 'Delete all old and unpayied reservations';

    public function handle()
    {
        $this->info('Start deleting');

        $reservations = Reservation::query()
            ->where('status', Status::Pending)
            ->when(!$this->option('all'), function ($q) {
                $q->where('created_at', '<', Carbon::now()->subHours(5));
            })
            ->get();
        foreach ($reservations as $reservation) {
            $reservation_requests = ReservationRequest::query()
                ->where('reservation_id', $reservation->id)
                ->get();
            foreach ($reservation_requests as $reservation_request) {
                $reservation_request->update([
                    'reservation_id' => null,
                    'status' => \App\Enums\ReservationRequest\Status::Rejected,
                    'status_text' => 'Закончился период ожидания оплаты'
                ]);
            }
            $reservation->delete();
        }
        $this->info('Finished deleting');
    }
}
