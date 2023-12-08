<?php

namespace App\Enums\Reservation;

enum Status: string
{
    case Pending = 'pending';
    case FirstPayment = 'first_payment';
    case Paid = 'paid';
}
