<?php

declare(strict_types=1);

namespace App\Services\Transfer\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use RuntimeException;
use Telegram\Bot\Objects\Update;

final class UserRepository
{
    public function findOrCreateFromUpdate(Update $update): ?User
    {
        $from = $update->message?->from ?? $update->callbackQuery?->from;

        if (!$from) {
            return null;
        }

        $username = $from->username ?? 'random_' . Str::random(8);
        $chatId = $this->extractChatId($update);

        return User::query()
            ->where('telegram_username', $username)
            ->firstOr(function () use ($username, $chatId, $from) {
                return $this->createUser($username, $chatId, $from);
            });
    }

    private function createUser(string $username, ?int $chatId, object $from): User
    {
        return User::query()->create([
            'telegram_username' => $username,
            'telegram_chat_id' => $chatId,
            'name' => $this->extractName($from),
        ]);
    }

    private function extractName(object $from): string
    {
        $name = trim(($from->firstName ?? '') . ' ' . ($from->lastName ?? ''));

        if (!$name) {
            throw new RuntimeException('Cannot extract user name from Telegram data');
        }

        return $name;
    }

    private function extractChatId(Update $update): ?int
    {
        return $update->getMessage()?->getChat()?->getId()
            ?? $update->callbackQuery?->message?->chat?->id;
    }
}
