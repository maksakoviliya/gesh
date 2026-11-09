<?php

declare(strict_types=1);

namespace App\Services\Transfer\Repositories;

use App\Models\User;
use RuntimeException;
use Telegram\Bot\Objects\Update;

final class UserRepository
{
    public function findOrCreateFromUpdate(Update $update): ?User
    {
        $from = $update->message?->from ?? $update->callbackQuery?->from;

        if (! $from) {
            return null;
        }

        // Telegram user id == private chat id and never changes, unlike username (which may be absent).
        $telegramId = (string) $from->id;
        $username = $from->username ?? null;

        $user = User::query()
            ->where('telegram_chat_id', $telegramId)
            ->orderByRaw('phone IS NULL')
            ->first();

        if (! $user && $username) {
            $user = User::query()->where('telegram_username', $username)->first();
            $user?->update(['telegram_chat_id' => $telegramId]);
        }

        return $user ?? User::query()->create([
            'telegram_username' => $username,
            'telegram_chat_id' => $telegramId,
            'name' => $this->extractName($from),
        ]);
    }

    private function extractName(object $from): string
    {
        $name = trim(($from->firstName ?? '').' '.($from->lastName ?? ''));

        if (! $name) {
            throw new RuntimeException('Cannot extract user name from Telegram data');
        }

        return $name;
    }
}
