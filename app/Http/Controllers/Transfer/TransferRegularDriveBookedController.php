<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\Transfer\DriveUser;
use Illuminate\Http\Request;

final class TransferRegularDriveBookedController extends Controller
{
    public function __invoke(Request $request, DriveUser $booking)
    {
        dd($booking);
    }
}
