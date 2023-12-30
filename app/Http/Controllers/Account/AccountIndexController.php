<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Enums\ReservationRequest\Status;
use App\Http\Controllers\Controller;
use App\Models\ReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final class AccountIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $reservation_requests_count = ReservationRequest::query()
            ->where('user_id', Auth::id())
            ->where('status', Status::Pending)
            ->count();
        return Inertia::render('Account/Index', [
            'reservation_requests_count' => $reservation_requests_count
        ]);
    }
}
