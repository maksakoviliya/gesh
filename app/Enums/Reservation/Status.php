<?php

namespace App\Enums\Reservation;

enum Status: string
{
    case Pending = 'pending';
    case PaymentWaiting = 'payment_waiting';
    case Paid = 'paid';
}
