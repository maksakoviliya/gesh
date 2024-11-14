<?php

declare(strict_types=1);

namespace App\Console\Commands\Transfer;

use App\Enums\Transfer\DriveUserStatus;
use App\Models\Transfer\DriveUser;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

final class ClearOldPendingDriveUserEntities extends Command
{
    protected $signature = 'app:clear-old-pending-drive-user-entities';

    protected $description = 'Remove old pending drive user entities';

    public function handle(): int
    {
        DriveUser::query()
            ->where('status', DriveUserStatus::Pending)
            ->where('created_at', '<', Carbon::now()->subMinutes(10))
            ->delete();

        return parent::SUCCESS;
    }
}
