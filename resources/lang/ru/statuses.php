<?php

use App\Enums\Apartments\Status;
use App\Enums\ReservationRequest\Status as ReservationRequestStatus;

return [
    Status::Draft->value => 'Черновик',
    Status::Pending->value => 'На модерации',
    Status::Published->value => 'Опубликован',

    'reservation_request' => [
        ReservationRequestStatus::Submitted->value => 'Одобрен',
        ReservationRequestStatus::Pending->value => 'Ожидает',
        ReservationRequestStatus::Rejected->value => 'Отказано',
    ],
];
