<?php

use App\Enums\Apartments\Status;
use App\Enums\ReservationRequest\Status as ReservationRequestStatus;
use App\Enums\Reservation\Status as ReservationStatus;

return [
    Status::Draft->value => 'Черновик',
    Status::Pending->value => 'На модерации',
    Status::Published->value => 'Опубликован',

    'reservation_request' => [
        ReservationRequestStatus::Submitted->value => 'Одобрен',
        ReservationRequestStatus::Pending->value => 'Ожидает',
        ReservationRequestStatus::Rejected->value => 'Отказано',
    ],

    'reservation' => [
        ReservationStatus::Pending->value => 'Ожидает',
        ReservationStatus::PaymentWaiting->value => 'Ожидает оплаты',
        ReservationStatus::FirstPayment->value => 'Частично оплачен',
        ReservationStatus::Paid->value => 'Оплачен',
    ],
];
