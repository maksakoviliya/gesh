<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\LogEvents\NamesEnum as LogEventNamesEnum;
use App\Models\LogEvent;
use App\Models\User;

final class LogService
{
    public function writeEvent(
        User $user,
        LogEventNamesEnum $name,
        array|string|null $data_before = null,
        array|string|null $data_after = null,
        ?string $eventable_type = null,
        ?string $eventable_id = null): LogService
    {
        LogEvent::query()
            ->create([
                'user_id' => $user->id,
                'name' => $name,
                'data_before' => $this->processData($data_before),
                'data_after' => $this->processData($data_after),
                'eventable_type' => $eventable_type,
                'eventable_id' => $eventable_id,
            ]);

        return $this;
    }

    protected function processData(array|string|null $data = null): array|string|null
    {
        if (! $data) {
            return null;
        }

        return $data;
    }
}
