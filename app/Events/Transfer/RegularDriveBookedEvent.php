<?php

declare(strict_types=1);

namespace App\Events\Transfer;

use App\Models\Transfer\DriveUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class RegularDriveBookedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public DriveUser $driveUser
    ) {}
}
