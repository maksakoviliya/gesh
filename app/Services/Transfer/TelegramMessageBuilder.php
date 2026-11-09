<?php

declare(strict_types=1);

namespace App\Services\Transfer;

use App\Enums\Transfer\ButtonDataEnum;
use App\Enums\Transfer\DestinationEnum;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

final class TelegramMessageBuilder
{
    private const BOT_NAME = 'transferBot';

    public const TIMEZONE = 'Asia/Novokuznetsk';

    public const CALLBACK_DATE = 'date:';

    public const CALLBACK_MONTH = 'cal:';

    public const CALLBACK_NOOP = 'noop';

    public const CALLBACK_HOUR = 'hour:';

    public const CALLBACK_HOURS = 'hours';

    public const CALLBACK_TIME = 'time:';

    public const CALLBACK_PASSENGERS = 'pax:';

    private const MONTHS = [
        'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь',
    ];

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

    public function sendDatePicker(int $chatId): void
    {
        $this->send(
            $chatId,
            "Выберите дату поездки\n(или напишите её в формате ДД.ММ.ГГГГ)",
            self::calendarKeyboard(self::today())
        );
    }

    public function sendTimePicker(int $chatId): void
    {
        $this->send($chatId, "Выберите час выезда\n(или напишите время в формате ЧЧ:ММ)", self::hoursKeyboard());
    }

    public function sendPassengersPicker(int $chatId): void
    {
        $this->send($chatId, "Сколько пассажиров?\n(если больше 8 — напишите числом)", self::passengersKeyboard());
    }

    /** Swaps the buttons of an existing message: calendar month, hour → minutes. */
    public function editKeyboard(int $chatId, int $messageId, Keyboard $keyboard): void
    {
        try {
            Telegram::bot(self::BOT_NAME)->editMessageReplyMarkup([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'reply_markup' => $keyboard,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to edit telegram keyboard', ['chat_id' => $chatId, 'error' => $e->getMessage()]);
        }
    }

    public static function hoursKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()->inline();
        foreach (array_chunk(range(0, 23), 4) as $hours) {
            $keyboard->row(array_map(
                static fn (int $h) => Keyboard::inlineButton(['text' => sprintf('%02d:00', $h), 'callback_data' => self::CALLBACK_HOUR.$h]),
                $hours
            ));
        }

        return $keyboard;
    }

    public static function minutesKeyboard(int $hour): Keyboard
    {
        return Keyboard::make()->inline()
            ->row(array_map(
                static fn (int $m) => Keyboard::inlineButton(['text' => $t = sprintf('%02d:%02d', $hour, $m), 'callback_data' => self::CALLBACK_TIME.$t]),
                [0, 15, 30, 45]
            ))
            ->row([Keyboard::inlineButton(['text' => '◀ Другой час', 'callback_data' => self::CALLBACK_HOURS])]);
    }

    public static function passengersKeyboard(): Keyboard
    {
        $keyboard = Keyboard::make()->inline();
        foreach (array_chunk(range(1, 8), 4) as $counts) {
            $keyboard->row(array_map(
                static fn (int $n) => Keyboard::inlineButton(['text' => (string) $n, 'callback_data' => self::CALLBACK_PASSENGERS.$n]),
                $counts
            ));
        }

        return $keyboard;
    }

    /** Replaces a message (and drops its buttons) with plain text. */
    public function replaceWithText(int $chatId, int $messageId, string $text): void
    {
        try {
            Telegram::bot(self::BOT_NAME)->editMessageText([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'text' => $text,
            ]);
        } catch (Throwable $e) {
            Log::warning('Failed to edit telegram message', ['chat_id' => $chatId, 'error' => $e->getMessage()]);
        }
    }

    /** "Today" for the customer: the app runs in UTC, Sheregesh is UTC+7. */
    public static function today(): Carbon
    {
        return Carbon::now(self::TIMEZONE)->startOfDay();
    }

    public static function calendarKeyboard(Carbon $month): Keyboard
    {
        $today = self::today();
        $month = $month->copy()->setTimezone(self::TIMEZONE)->startOfMonth();
        if ($month->lt($today->copy()->startOfMonth())) {
            $month = $today->copy()->startOfMonth();
        }

        $noop = static fn (string $text) => Keyboard::inlineButton(['text' => $text, 'callback_data' => self::CALLBACK_NOOP]);
        $isCurrentMonth = $month->isSameMonth($today);

        $keyboard = Keyboard::make()->inline()
            ->row([
                $isCurrentMonth
                    ? $noop(' ')
                    : Keyboard::inlineButton(['text' => '◀', 'callback_data' => self::CALLBACK_MONTH.$month->copy()->subMonth()->format('Y-m')]),
                $noop(self::MONTHS[$month->month - 1].' '.$month->year),
                Keyboard::inlineButton(['text' => '▶', 'callback_data' => self::CALLBACK_MONTH.$month->copy()->addMonth()->format('Y-m')]),
            ])
            ->row(array_map($noop, ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс']));

        // Pad the first week so day 1 lands under its weekday (Mon = column 0).
        $week = array_fill(0, $month->dayOfWeekIso - 1, $noop(' '));
        for ($day = $month->copy(); $day->isSameMonth($month); $day->addDay()) {
            $week[] = $day->lt($today)
                ? $noop('·')
                : Keyboard::inlineButton(['text' => (string) $day->day, 'callback_data' => self::CALLBACK_DATE.$day->format('Y-m-d')]);

            if (count($week) === 7) {
                $keyboard->row($week);
                $week = [];
            }
        }
        if ($week) {
            $keyboard->row(array_pad($week, 7, $noop(' ')));
        }

        return $keyboard;
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
