<?php

declare(strict_types=1);

namespace App\Actions\ContactRequest;

use App\Actions\TelegramNotifications\SendMessageToAdminGroup;
use App\Models\ContactRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

final class ContactRequestStoreAction
{
    public function __construct(
        protected SendMessageToAdminGroup $telegram
    ) {}

    public function run(array $data): ContactRequest
    {
        /** @var ContactRequest $contactRequest */
        $contactRequest = ContactRequest::query()
            ->create([
                'apartment_id' => Arr::get($data, 'apartment_id'),
                'user_id' => Arr::get($data, 'user_id'),
                'name' => Arr::get($data, 'name'),
                'phone' => Arr::get($data, 'phone'),
                'telegram_username' => Arr::get($data, 'telegram_username'),
            ]);

        $this->telegram->sendNewContactRequest($contactRequest);

        return $contactRequest;
    }
}
