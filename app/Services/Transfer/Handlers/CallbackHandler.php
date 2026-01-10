<?php

declare(strict_types=1);

namespace App\Services\Transfer\Handlers;

use App\Enums\Transfer\ButtonDataEnum;
use App\Enums\Transfer\DestinationEnum;
use App\Enums\Transfer\RequestStatusEnum;
use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\ConversationManager;
use App\Services\Transfer\TelegramMessageBuilder;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\Update;
use ValueError;

final readonly class CallbackHandler
{
    public function __construct(
        private ConversationManager $conversationManager,
        private TelegramMessageBuilder $messageBuilder,
    ) {}

    public function handle(Update $update, User $user, int $chatId): void
    {
        $callbackData = $update->callbackQuery->data;

        // Обработка кнопки "Начать заново"
        if ($callbackData === ButtonDataEnum::PUSH_START->value) {
            $this->messageBuilder->sendWelcome($chatId, $user);
            return;
        }

        // Обработка выбора типа услуги
        try {
            $serviceType = ButtonDataEnum::from($callbackData);
            $request = $this->getOrCreateDraftRequest($user, $serviceType);
            $this->conversationManager->processStep($request, $user, $chatId);
            return;
        } catch (ValueError) {
            // Не является типом услуги, продолжаем
        }

        // Обработка выбора направления
        try {
            $destination = DestinationEnum::from($callbackData);
            $request = $this->getLatestDraftRequest($user);

            if (!$request) {
                Log::error('No draft request found for destination selection', ['user_id' => $user->id]);
                $this->conversationManager->sendError($chatId);
                return;
            }

            $request->update(['destination' => $destination->value]);
            $this->conversationManager->processStep($request, $user, $chatId);
            return;
        } catch (ValueError) {
            // Не является направлением
        }

        Log::warning('Unknown callback data', ['data' => $callbackData]);
    }

    private function getOrCreateDraftRequest(User $user, ButtonDataEnum $type): TransferRequest
    {
        /** @var TransferRequest $request */
        $request = TransferRequest::query()
            ->firstOrCreate(
                [
                    'user_id' => $user->id,
                    'type' => $type,
                    'status' => RequestStatusEnum::DRAFT,
                ],
                [
                    'user_id' => $user->id,
                    'type' => $type,
                    'status' => RequestStatusEnum::DRAFT,
                ]
            );

        return $request;
    }

    private function getLatestDraftRequest(User $user): ?TransferRequest
    {
        /** @var TransferRequest $transferRequest */
        $transferRequest = TransferRequest::query()
            ->where('user_id', $user->id)
            ->where('status', RequestStatusEnum::DRAFT)
            ->latest('updated_at')
            ->first();

        return $transferRequest;
    }
}
