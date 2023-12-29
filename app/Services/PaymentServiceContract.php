<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Http\Request;

interface PaymentServiceContract
{
    public function getClient();

    public function createPayment(int $amount, string $return_url, Reservation $reservation);

    public function callback(Request $request);
}
