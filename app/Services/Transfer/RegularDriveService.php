<?php

declare(strict_types=1);

namespace App\Services\Transfer;

use App\Models\Transfer\DriveUser;
use App\Models\Transfer\RegularDrive;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

final class RegularDriveService
{
    private int $days = 14;

    public function getAvailableSeats(RegularDrive $drive): array
    {
        $result = [];
        for ($date = Carbon::now(); $date <= Carbon::now()->addDays($this->days); $date->addDay()) {
            $result[$date->format('d.m.Y')] = [
                'available_seats' => $this->getAvailableSeatsForDay($drive, $date),
                'price' => $this->getPriceForDay($drive, $date),
            ];
        }

        return $result;
    }

    protected function getAvailableSeatsForDay(RegularDrive $drive, CarbonInterface $date): int
    {
        $passengers = DriveUser::query()
            ->where('drive_id', $drive->id)
            ->whereDate('start_at', $date)
            ->count();

        return $drive->passengers_limit - $passengers;
    }

    protected function getPriceForDay(RegularDrive $drive, CarbonInterface $date): int
    {
        return $drive->regular_price;
    }
}
