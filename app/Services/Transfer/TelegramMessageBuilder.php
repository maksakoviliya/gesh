<?php

declare(strict_types=1);

namespace App\Services\Transfer;

use App\Enums\Transfer\ButtonDataEnum;
use App\Enums\Transfer\DestinationEnum;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

final class TelegramMessageBuilder
{
    private const BOT_NAME = 'transferBot';

    public function sendSimple(int $chatId, string $text): void
    {
        $this->send($chatId, $text);
    }

    public function sendWelcome(int $chatId, User $user): void
    {
        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => '🚖 Такси',
                    'callback_data' => ButtonDataEnum::TAXI->value,
                ]),
            ])
            ->row([
                Keyboard::inlineButton([
                    'text' => '🚐 Трансфер с попутчиками',
                    'callback_data' => ButtonDataEnum::TRANSFER->value,
                ]),
            ]);

        $this->send(
            $chatId,
            "Привет, {$user->name}!\nВыберите необходимую услугу:",
            $keyboard
        );
    }

    public function sendDestinationSelection(int $chatId): void
    {
        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => '✈️ В Аэропорт',
                    'callback_data' => DestinationEnum::AIRPORT->value,
                ]),
            ])
            ->row([
                Keyboard::inlineButton([
                    'text' => '⛷️️ В Шерегеш',
                    'callback_data' => DestinationEnum::SHEREGESH->value,
                ]),
            ]);

        $this->send($chatId, 'Выберите направление', $keyboard);
    }

    public function sendPhoneRequest(int $chatId): void
    {
        $keyboard = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->row([
                Keyboard::button([
                    'text' => '📱 Отправить номер телефона',
                    'request_contact' => true,
                ]),
            ]);

        $this->send(
            $chatId,
            'Для завершения заказа, пожалуйста, поделитесь своим номером телефона',
            $keyboard
        );
    }

    public function sendSuccess(int $chatId, User $user): void
    {
        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => 'Начать заново',
                    'callback_data' => ButtonDataEnum::PUSH_START->value,
                ]),
            ]);

        $telegram = $user->telegram_username
            ? " в телеграм: {$user->telegram_username} или "
            : '';

        $this->send(
            $chatId,
            "Спасибо, {$user->name}!\nВ ближайшее время с вами свяжутся{$telegram}по телефону: {$user->phone}",
            $keyboard
        );
    }

    /** Stops the loading spinner on the pressed inline button. */
    public function answerCallback(string $callbackQueryId): void
    {
        try {
            Telegram::bot(self::BOT_NAME)->answerCallbackQuery(['callback_query_id' => $callbackQueryId]);
        } catch (Throwable $e) {
            Log::warning('Failed to answer callback query', ['error' => $e->getMessage()]);
        }
    }

    private function send(int $chatId, string $text, ?Keyboard $keyboard = null): void
    {
        try {
            $params = [
                'chat_id' => $chatId,
                'text' => $text,
            ];

            if ($keyboard) {
                $params['reply_markup'] = $keyboard;
            }

            Telegram::bot(self::BOT_NAME)->sendMessage($params);
        } catch (Throwable $e) {
            Log::error('Failed to send telegram message', [
                'chat_id' => $chatId,
                'error' => $e->getMessage(),
            ]);
        }
    }
}