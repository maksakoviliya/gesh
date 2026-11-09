<?php

declare(strict_types=1);

namespace App\Services\Transfer\Conversation;

use App\Enums\Transfer\RequestStatusEnum;
use App\Events\Transfer\NewBotUsageEvent;
use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\Steps\EnterDateStep;
use App\Services\Transfer\Conversation\Steps\EnterPassengersStep;
use App\Services\Transfer\Conversation\Steps\EnterPhoneStep;
use App\Services\Transfer\Conversation\Steps\EnterTimeStep;
use App\Services\Transfer\Conversation\Steps\SelectDestinationStep;
use App\Services\Transfer\TelegramMessageBuilder;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final readonly class ConversationManager
{
    public function __construct(
        private readonly TelegramMessageBuilder $messageBuilder,
    ) {}

    public function processStep(TransferRequest $request, User $user, int $chatId): void
    {
        // Проверка: если заявка уже завершена, не обрабатываем
        if ($this->isRequestComplete($request, $user)) {
            $this->completeRequest($request, $user, $chatId);

            return;
        }

        try {
            $step = $this->getCurrentStep($request, $user);

            if ($step->isComplete($request, $user)) {
                $nextStep = $step->next();
                if ($nextStep) {
                    $nextStep->prompt($chatId, $this->messageBuilder);
                } else {
                    $this->completeRequest($request, $user, $chatId);
                }
            } else {
                $step->prompt($chatId, $this->messageBuilder);
            }
        } catch (RuntimeException $e) {
            // Если не можем определить шаг, но все поля заполнены - завершаем
            if ($this->isRequestComplete($request, $user)) {
                $this->completeRequest($request, $user, $chatId);
            } else {
                Log::error('Cannot determine conversation step', [
                    'request_id' => $request->id,
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }
        }
    }

    public function processInput(TransferRequest $request, User $user, int $chatId, string $input): void
    {
        // Проверка: если заявка уже завершена
        if ($this->isRequestComplete($request, $user)) {
            $this->messageBuilder->sendSimple(
                $chatId,
                "Ваша заявка уже принята!\nДля новой заявки используйте: /start"
            );

            return;
        }

        try {
            $step = $this->getCurrentStep($request, $user);

            if ($step->isComplete($request, $user)) {
                // Шаг уже завершён, переходим к следующему
                $this->processStep($request, $user, $chatId);

                return;
            }

            $result = $step->process($request, $user, $input);

            if (! $result) {
                // Валидация не прошла, показываем ошибку
                $this->messageBuilder->sendSimple($chatId, $step->getErrorMessage());

                return;
            }

            // Обновляем request из БД
            $request = $request->fresh();

            // Переходим к следующему шагу
            $this->processStep($request, $user, $chatId);
        } catch (RuntimeException $e) {
            Log::error('Error processing input', [
                'request_id' => $request->id,
                'user_id' => $user->id,
                'input' => $input,
                'error' => $e->getMessage(),
            ]);
            $this->sendError($chatId);
        }
    }

    /**
     * Завершение заявки после получения телефона
     * Используется в ContactHandler, когда все поля уже заполнены
     */
    public function completeRequestAfterPhone(TransferRequest $request, User $user, int $chatId): void
    {
        // Проверяем, что все обязательные поля заполнены
        if ($this->isRequestComplete($request, $user)) {
            $this->completeRequest($request, $user, $chatId);
        } else {
            // Если чего-то не хватает, продолжаем диалог
            $this->processStep($request, $user, $chatId);
        }
    }

    private function getCurrentStep(TransferRequest $request, User $user): StepInterface
    {
        return match (true) {
            ! $request->destination => new SelectDestinationStep,
            ! $request->start_at => new EnterDateStep,
            ! $request->start_time => new EnterTimeStep,
            ! $request->passengers_count => new EnterPassengersStep,
            ! $user->phone => new EnterPhoneStep,
            default => throw new RuntimeException('Cannot determine current step: all fields are filled'),
        };
    }

    private function isRequestComplete(TransferRequest $request, User $user): bool
    {
        return $request->destination !== null
            && $request->start_at !== null
            && $request->start_time !== null
            && $request->passengers_count !== null
            && $user->phone !== null;
    }

    private function completeRequest(TransferRequest $request, User $user, int $chatId): void
    {
        // Проверяем статус перед обновлением, чтобы не отправлять событие дважды
        if ($request->status === RequestStatusEnum::PENDING) {
            return;
        }

        $request->update(['status' => RequestStatusEnum::PENDING]);

        $this->messageBuilder->sendSuccess($chatId, $user);

        event(new NewBotUsageEvent($request));
    }

    public function sendError(int $chatId): void
    {
        $this->messageBuilder->sendSimple(
            $chatId,
            "Что-то пошло не так ((\nПопробуйте начать с начала: /start"
        );
    }

    public function sendPhoneError(int $chatId): void
    {
        $this->messageBuilder->sendSimple(
            $chatId,
            'Не удалось обработать номер телефона. Пожалуйста, отправьте свой контакт ещё раз.'
        );
    }
}
