<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\RegularRide\BookRequest;
use App\Models\Transfer\RegularDrive;
use App\Services\Transfer\RegularDriveService;
use Illuminate\Http\RedirectResponse;

final class TransferRegularDriveBookingController extends Controller
{
    public function __construct(
        protected RegularDriveService $regularDriveService
    ) {}

    public function __invoke(BookRequest $request, RegularDrive $drive): RedirectResponse
    {
        if (! $booking = $this->regularDriveService->bookDrive($drive, $request->validated())) {
            return back()->withErrors(['booking' => 'Ошибка при бронировании мест']);
        }

        return back()->with('info', 'Трансфер успешно забронирован.');
        //        return to_route('transfer.regular-ride.booked', $booking->id);
    }
}
