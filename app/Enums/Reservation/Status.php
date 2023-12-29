<?php

namespace App\Enums\Reservation;

enum Status: string
{
    case Pending = 'pending';
    case PaymentWaiting = 'payment_waiting';
    case FirstPayment = 'first_payment';
    case Paid = 'paid';
}
