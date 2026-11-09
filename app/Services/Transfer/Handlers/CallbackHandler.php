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
use App\Services\Transfer\Validators\PassengersValidator;
use App\Services\Transfer\Validators\TimeValidator;
use Illuminate\Support\Carbon;
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
        $this->messageBuilder->answerCallback((string) $update->callbackQuery->id);

        // Календарь: пустые клетки, листание месяцев, выбор дня
        if ($callbackData === TelegramMessageBuilder::CALLBACK_NOOP) {
            return;
        }

        $messageId = (int) $update->callbackQuery->message?->messageId;

        if (str_starts_with($callbackData, TelegramMessageBuilder::CALLBACK_MONTH)) {
            $month = Carbon::createFromFormat('!Y-m', substr($callbackData, strlen(TelegramMessageBuilder::CALLBACK_MONTH)), TelegramMessageBuilder::TIMEZONE);
            $this->messageBuilder->editKeyboard($chatId, $messageId, TelegramMessageBuilder::calendarKeyboard($month));

            return;
        }

        if (str_starts_with($callbackData, TelegramMessageBuilder::CALLBACK_DATE)) {
            $this->handleDate($user, $chatId, $messageId, substr($callbackData, strlen(TelegramMessageBuilder::CALLBACK_DATE)));

            return;
        }

        // Время: час → минуты (◀ назад к часам) → сохранение
        if (str_starts_with($callbackData, TelegramMessageBuilder::CALLBACK_HOUR)) {
            $hour = (int) substr($callbackData, strlen(TelegramMessageBuilder::CALLBACK_HOUR));
            $this->messageBuilder->editKeyboard($chatId, $messageId, TelegramMessageBuilder::minutesKeyboard(min(max($hour, 0), 23)));

            return;
        }

        if ($callbackData === TelegramMessageBuilder::CALLBACK_HOURS) {
            $this->messageBuilder->editKeyboard($chatId, $messageId, TelegramMessageBuilder::hoursKeyboard());

            return;
        }

        if (str_starts_with($callbackData, TelegramMessageBuilder::CALLBACK_TIME)) {
            $time = substr($callbackData, strlen(TelegramMessageBuilder::CALLBACK_TIME));
            if ((new TimeValidator)->validate($time)) {
                $this->applyToDraft($user, $chatId, $messageId, ['start_time' => $time], '🕐 Время выезда: '.$time);
            }

            return;
        }

        if (str_starts_with($callbackData, TelegramMessageBuilder::CALLBACK_PASSENGERS)) {
            $count = (new PassengersValidator)->parse(substr($callbackData, strlen(TelegramMessageBuilder::CALLBACK_PASSENGERS)));
            if ($count !== null) {
                $this->applyToDraft($user, $chatId, $messageId, ['passengers_count' => $count], '👥 Пассажиров: '.$count);
            }

            return;
        }

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

            if (! $request) {
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

    private function handleDate(User $user, int $chatId, int $messageId, string $value): void
    {
        $date = Carbon::createFromFormat('!Y-m-d', $value, TelegramMessageBuilder::TIMEZONE);

        // Старый календарь мог остаться в чате с прошлых дней
        if ($date->lt(TelegramMessageBuilder::today())) {
            $this->messageBuilder->sendSimple($chatId, 'Эта дата уже прошла, выберите другую.');
            $this->messageBuilder->sendDatePicker($chatId);

            return;
        }

        $this->applyToDraft($user, $chatId, $messageId, ['start_at' => $date->toDateString()], '📅 Дата поездки: '.$date->format('d.m.Y'));
    }

    /** Saves a button choice into the current draft and moves the dialog to the next step. */
    private function applyToDraft(User $user, int $chatId, int $messageId, array $attributes, string $summary): void
    {
        $request = $this->getLatestDraftRequest($user);
        if (! $request) {
            $this->conversationManager->sendError($chatId);

            return;
        }

        $request->update($attributes);
        // Убираем кнопки, чтобы выбор был виден и не нажимался повторно
        $this->messageBuilder->replaceWithText($chatId, $messageId, $summary);
        $this->conversationManager->processStep($request->fresh(), $user, $chatId);
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
