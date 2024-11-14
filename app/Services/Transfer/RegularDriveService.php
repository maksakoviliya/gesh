<?php

declare(strict_types=1);

namespace App\Services\Transfer;

use App\Enums\Transfer\DriveUserStatus;
use App\Events\Transfer\RegularDriveBookedEvent;
use App\Models\Transfer\DriveUser;
use App\Models\Transfer\RegularDrive;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function getAvailableSeatsForDay(RegularDrive $drive, CarbonInterface $date): int
    {
        $passengers = DriveUser::query()
            ->where('drive_id', $drive->id)
            ->whereDate('start_at', $date)
            ->sum('seats_count');

        return $drive->passengers_limit - $passengers;
    }

    protected function getPriceForDay(RegularDrive $drive, CarbonInterface $date): int
    {
        return $drive->regular_price;
    }

    public function bookDrive(RegularDrive $drive, array $params): Model|Builder
    {
        $driveUser = DriveUser::query()
            ->create([
                'drive_id' => $drive->id,
                'user_id' => Auth::id(),
                'status' => DriveUserStatus::Pending,
                'start_at' => $params['start_at'],
                'seats_count' => $params['seats_count'],
            ]);

        RegularDriveBookedEvent::dispatch($driveUser);

        return $driveUser;
    }
}
