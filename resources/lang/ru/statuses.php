<?php

use App\Enums\Apartments\Status;

return [
    Status::Draft->value => 'Черновик',
    Status::Pending->value => 'На модерации',
    Status::Published->value => 'Опубликован',
];
