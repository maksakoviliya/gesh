<?php

declare(strict_types=1);

namespace App\Services\Transfer;

use App\Enums\Transfer\ButtonDataEnum;
use App\Enums\Transfer\DestinationEnum;
use App\Enums\Transfer\RequestStatusEnum;
use App\Events\Transfer\NewBotUsageEvent;
use App\Models\TransferRequest;
use App\Models\User;
use Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Log;
use Propaganistas\LaravelPhone\PhoneNumber;
use RuntimeException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;
use Throwable;

final class TelegramService
{
    public function getUserFromUpdateData(Update $update): ?User
    {
        $from = $update->getChat();
        Log::info(json_encode($from));
        $username = $from->username;
        if (! $username) {
            $username = 'random_'.Str::random(8);
        }
        if (! $user = User::query()
            ->where('telegram_username', $username)->first()) {
            $name = "$from->first_name $from->last_name";
            if (! trim($name)) {
                throw new RuntimeException('No name found');
            }

            return User::query()->create([
                'telegram_username' => $username,
                'telegram_chat_id' => $update->getMessage()?->getChat()?->getId() ?? null,
                'name' => $name,
            ]);
        }

        return $user;
    }

    /**
     * @throws TelegramSDKException
     */
    public function processUpdates(array|Update $update): void
    {
        if ($entities = $update->getMessage()?->entities) {
            $type = Arr::get($entities, '0.type');
            if ($type === 'bot_command') {
                return;
            }
        }

        $data = $update->getRelatedObject()?->data;
        Log::debug(__METHOD__.', Data: '.json_encode($data));
        if (! $data) {
            $this->processText($update);

            return;
        }
        $this->processButtonClick($update, $data);
    }

    /**
     * @throws TelegramSDKException
     */
    protected function processButtonClick(Update $update, string $button_data): void
    {
        $user = $this->getUserFromUpdateData($update);
        if (! $user) {
            Log::error('No user found: '.__METHOD__);

            return;
        }

        $chatId = $update->getMessage()->getChat()->getId();
        if (! $chatId) {
            Log::error('No chatId found: '.__METHOD__);

            return;
        }
        $request = TransferRequest::query()
            ->where('user_id', $user->id)
            ->where('status', RequestStatusEnum::DRAFT);

        try {
            $type = ButtonDataEnum::from($button_data);

            if ($type === ButtonDataEnum::PUSH_START) {
                $this->sendStartMessage($chatId, $user);

                return;
            }

            $request = $request->where('type', $type)->first();
            if (! $request) {
                $request = TransferRequest::query()
                    ->create([
                        'user_id' => $user->id,
                        'type' => $type,
                        'status' => RequestStatusEnum::DRAFT,
                    ]);
            }
        } catch (Throwable $exception) {
            Log::debug($exception->getMessage());
            $request = $request->orderBy('updated_at', 'desc')->first();
        }

        try {
            $destination = DestinationEnum::from($button_data);
            $this->processDestinationValue($request, $destination);
            $request = $request->fresh();

        } catch (Throwable $exception) {
            Log::debug($exception->getMessage());
        }

        $this->sendRequestMessage($chatId, $request);
    }

    protected function sendRequestMessage(string|int $chatId, TransferRequest $request): void
    {
        if (! $request->destination) {
            $this->sendDestinationMessage($chatId);

            return;
        }

        if (! $request->start_at) {
            $this->sendSimpleMessage($chatId, 'Введите дату в формате ДД.ММ.ГГГГ');

            return;
        }

        if (! $request->start_time) {
            $this->sendSimpleMessage($chatId, 'Введите время в формате ЧЧ:ММ');

            return;
        }

        if (! $request->passengers_count) {
            $this->sendSimpleMessage($chatId, 'Введите количество пассажиров');

            return;
        }

        if (! $request->user?->phone) {
            $this->sendSimpleMessage($chatId, 'Укажите ваш контактный телефон в формате +7XXXXXXXXXX');

            return;
        }

        //        $this->sendSimpleMessage($chatId, "Спасибо, {$request->user?->name}! \n В ближайшее время с вами свяжутся в телеграм: {$request->user?->telegram_username} или по телефону: {$request->user?->phone}");

        $request->update([
            'status' => RequestStatusEnum::PENDING,
        ]);

        NewBotUsageEvent::dispatch($request);
    }

    /**
     * @throws TelegramSDKException
     */
    protected function processText(Update $update): void
    {
        $user = $this->getUserFromUpdateData($update);
        if (! $user) {
            Log::error('Can not find user: '.__METHOD__);

            return;
        }
        $chatId = $update->getMessage()->getChat()->getId();
        if (! $chatId) {
            Log::error('Can not find chatId: '.__METHOD__);

            return;
        }

        /** @var TransferRequest $request */
        $request = TransferRequest::query()
            ->where('user_id', $user->id)
            ->where('status', RequestStatusEnum::DRAFT->value)
            ->orderBy('created_at', 'desc')
            ->first();
        if (! $request) {
            Log::error('Cannot find request: '.__METHOD__);
            $this->sendSimpleMessage($chatId, "Что-то пошло не так (( \n Попробуйте начать с начала, выполнив команду /start");

            return;
        }

        $text = $update->getMessage()->text;

        if (! $request->destination) {
            $this->sendDestinationMessage($chatId);

            return;
        }

        if (! $request->start_at) {
            $this->processStartAtText($chatId, $request, $text);

            return;
        }

        if (! $request->start_time) {
            $this->processStartTimeText($chatId, $request, $text);

            return;
        }

        if (! $request->passengers_count) {
            if (! $this->processPassengersCountText($chatId, $request, $text)) {
                return;
            }
        }

        if (! $user->phone) {
            $this->processPhoneText($chatId, $request, $user, $text);
        }

        $this->sendSuccessText($chatId, $user);

        $request->update([
            'status' => RequestStatusEnum::PENDING,
        ]);

        NewBotUsageEvent::dispatch($request);
    }

    public function sendStartMessage(string|int $chatId, User $user): void
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

        try {
            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => "Привет, $user->name!\nВыберите необходимую услугу:",
                'reply_markup' => $keyboard,
            ]);

        } catch (Throwable $exception) {
            Log::error('Error sending message: '.$exception->getMessage());
        }
    }

    protected function sendSimpleMessage(string|int $chatId, string $text): void
    {
        try {
            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
            ]);
        } catch (Throwable $exception) {
            Log::error('Error sending message: '.$exception->getMessage());
            Log::error('Error in: '.__METHOD__);
        }
    }

    protected function sendDestinationMessage(string|int $chatId): void
    {
        try {
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

            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Выберите направление',
                'reply_markup' => $keyboard,
            ]);
        } catch (Throwable $exception) {
            Log::error('Error sending message: '.$exception->getMessage());
            Log::error('Error in: '.__METHOD__);
        }
    }

    protected function processStartAtText(string|int $chatId, TransferRequest $request, string $text): void
    {
        try {
            $date = Carbon::createFromFormat('d.m.Y', $text);
            $request->update([
                'start_at' => $date,
            ]);
            $this->sendSimpleMessage($chatId, 'Введите время в формате ЧЧ:ММ');
        } catch (Throwable $exception) {
            $this->sendSimpleMessage($chatId, 'Неверный формат даты. Нужно отправить в формате ДД.ММ.ГГГГ.');

            return;
        }
    }

    protected function processPassengersCountText(string|int $chatId, TransferRequest $request, string $text): bool
    {
        $passengers_count = intval($text);
        if (! $passengers_count) {
            $this->sendSimpleMessage($chatId, 'Неверный формат числа. Укажите целое число.');

            return false;
        }

        return $request->update([
            'passengers_count' => $passengers_count,
        ]);
    }

    protected function processPhoneText(string|int $chatId, TransferRequest $request, User $user, string $text): void
    {
        $phone = new PhoneNumber($text, 'ru');

        if (! $phone->isValid()) {
            $this->sendSimpleMessage($chatId, 'Неверно указан телефон. Укажите ваш контактный телефон в формате +7XXXXXXXXXX');

            return;
        }

        if ($oldUser = User::query()
            ->where('phone', $phone)->first()) {
            $username = $user->telegram_username;
            $chat_id = $user->telegram_chat_id;
            $user->delete();
            $oldUser->update([
                'telegram_username' => $username,
                'telegram_chat_id' => $chat_id,
            ]);
            $request->update([
                'user_id' => $oldUser->id,
            ]);
        } else {
            $user->update([
                'phone' => $phone,
            ]);
        }
    }

    /**
     * @throws TelegramSDKException
     */
    protected function sendSuccessText(string|int $chatId, User $user): void
    {
        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => 'Начать заново',
                    'callback_data' => ButtonDataEnum::PUSH_START->value,
                ]),
            ]);

        $tg = $user->telegram_username ? " в телеграм: $user->telegram_username или " : '';

        Telegram::bot('transferBot')->sendMessage([
            'chat_id' => $chatId,
            'text' => "Спасибо, $user->name! \n В ближайшее время с вами свяжутся".$tg."по телефону: $user->phone",
            'reply_markup' => $keyboard,
        ]);
    }

    protected function processDestinationValue(TransferRequest $request, DestinationEnum $type): void
    {
        $request->update([
            'destination' => $type->value,
        ]);
    }

    protected function processStartTimeText(string|int $chatId, TransferRequest $request, string $text): void
    {
        if (! $this->isCorrectTime($text)) {
            $this->sendSimpleMessage($chatId, 'Неверный формат времени. Нужно отправить в формате ЧЧ:ММ');

            return;
        }

        $request->update([
            'start_time' => $text,
        ]);

        $this->sendSimpleMessage($chatId, 'Введите количество пассажиров');
    }

    private function isCorrectTime(string $text): bool
    {
        if (! preg_match('/^(2[0-3]|[01]?[0-9]):([0-5]?[0-9])$/', $text)) {
            return false;
        }

        return true;
    }
}
