<?php

declare(strict_types=1);

namespace App\Services\Transfer\Handlers;

use App\Enums\Transfer\RequestStatusEnum;
use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\ConversationManager;
use Illuminate\Support\Facades\Log;
use Propaganistas\LaravelPhone\PhoneNumber;
use Telegram\Bot\Objects\Update;

final readonly class ContactHandler
{
    public function __construct(
        private ConversationManager $conversationManager,
    ) {}

    public function handle(Update $update, User $user, int $chatId): void
    {
        $contact = $update->getMessage()->contact;
        $phoneNumber = $contact->phoneNumber;

        // Нормализуем номер телефона
        try {
            $phone = new PhoneNumber($phoneNumber, 'RU');

            if (! $phone->isValid()) {
                $this->conversationManager->sendPhoneError($chatId);

                return;
            }

            // Находим текущую заявку ДО обновления пользователя
            $request = TransferRequest::query()
                ->where('user_id', $user->id)
                ->where('status', RequestStatusEnum::DRAFT)
                ->latest('created_at')
                ->first();

            if (! $request) {
                Log::error('No draft request found before phone update', ['user_id' => $user->id]);
                $this->conversationManager->sendError($chatId);

                return;
            }

            // Проверяем, существует ли уже пользователь с таким номером
            $existingUser = User::query()->where('phone', (string) $phone)->first();

            if ($existingUser && $existingUser->id !== $user->id) {
                // Переносим текущую сессию на существующего пользователя
                $this->mergeUsers($user, $existingUser);
                $user = $existingUser;
                // Обновляем заявку после слияния
                $request = $request->fresh();
            } else {
                $user->update(['phone' => (string) $phone]);
                $user = $user->fresh();
            }

            // Продолжаем обработку заявки с обновлённым пользователем
            $this->conversationManager->completeRequestAfterPhone($request, $user, $chatId);

        } catch (\Throwable $e) {
            Log::error('Error processing contact', [
                'error' => $e->getMessage(),
                'phone' => $phoneNumber,
                'trace' => $e->getTraceAsString(),
            ]);
            $this->conversationManager->sendPhoneError($chatId);
        }
    }

    private function mergeUsers(User $oldUser, User $existingUser): void
    {
        // Обновляем Telegram данные у существующего пользователя
        $existingUser->update([
            'telegram_username' => $oldUser->telegram_username,
            'telegram_chat_id' => $oldUser->telegram_chat_id,
        ]);

        // Переносим все заявки на существующего пользователя
        TransferRequest::query()
            ->where('user_id', $oldUser->id)
            ->update(['user_id' => $existingUser->id]);

        // Удаляем старого пользователя
        $oldUser->delete();
    }
}
