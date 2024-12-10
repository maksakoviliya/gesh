<?php

declare(strict_types=1);

namespace App\Services\Transfer;

use App\Commands\Transfer\StartCommand;
use App\Enums\Transfer\RequestStatusEnum;
use App\Enums\Transfer\RequestTypeEnum;
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
            $username = 'random_' . Str::random(8);
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
        Log::info('Updates: '.json_encode($update));
        if ($entities = $update->getMessage()->entities) {
            $type = Arr::get($entities, '0.type');
            if ($type === 'bot_command') {
                return;
            }
        }

        $data = $update->getRelatedObject()?->data;

        if ($data) {
            $this->processButtonClick($update, RequestTypeEnum::from($data));

            return;
        }

        $this->processText($update);
    }

    /**
     * @throws TelegramSDKException
     */
    protected function processButtonClick(Update $update, RequestTypeEnum $type): void
    {
        $user = $this->getUserFromUpdateData($update);
        if (! $user) {
            return;
        }

        if ($type === RequestTypeEnum::PUSH_START) {

            // TODO: Убрать дублирование кода
            $chatId = $update->getMessage()->getChat()->getId();

            $keyboard = Keyboard::make()
                ->inline()
                ->row([
                    Keyboard::inlineButton([
                        'text' => '🚖 Такси',
                        'callback_data' => RequestTypeEnum::TAXI->value,
                    ]),
                ])
                ->row([
                    Keyboard::inlineButton([
                        'text' => '🚐 Трансфер с попутчиками',
                        'callback_data' => RequestTypeEnum::TRANSFER->value,
                    ]),
                ]);

            try {
                Telegram::bot('transferBot')->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Привет, $user->name!\nВыберите необходимую услугу:",
                    'reply_markup' => $keyboard,
                ]);
               
            } catch (Throwable $exception) {
                \Illuminate\Support\Facades\Log::error('Error sending message: '.$exception->getMessage());
            }

            return;
        }

        $request = TransferRequest::query()
            ->where('status', RequestStatusEnum::DRAFT)
            ->where('user_id', $user->id)
            ->where('type', $type)
            ->first();
        if (! $request) {
            $request = TransferRequest::query()->create([
                'user_id' => $user->id,
                'status' => RequestStatusEnum::DRAFT,
                'type' => $type,
            ]);
        }

        $this->sendRequestMessage($update, $request);
    }

    /**
     * @throws TelegramSDKException
     */
    protected function sendRequestMessage(Update $update, TransferRequest $request): void
    {
        $chatId = $update->getMessage()->getChat()->getId();

        if (! $request->start_at) {
            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Введите дату в формате ДД.ММ.ГГГГ',
            ]);

            return;
        }

        if (! $request->passengers_count) {
            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Введите количество пассажиров',
            ]);

            return;
        }

        if (! $request->user?->phone) {
            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Укажите ваш контактный телефон',
            ]);

            return;
        }

        Telegram::bot('transferBot')->sendMessage([
            'chat_id' => $chatId,
            'text' => "Спасибо, {$request->user?->name}! \n В ближайшее время с вами свяжутся по телефону: {$request->user?->phone}",
        ]);
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
            return;
        }
        $chatId = $update->getMessage()->getChat()->getId();

        $request = TransferRequest::query()
            ->where('user_id', $user->id)
            ->where('status', RequestStatusEnum::DRAFT->value)
            ->orderBy('created_at', 'desc')
            ->first();
        if (! $request) {
            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => "Что-то пошло не так (( \n Попробуйте начать с начала, выполнив команду /start",
            ]);

            return;
        }

        $text = $update->getMessage()->text;

        if (! $request->start_at) {
            try {
                $date = Carbon::createFromFormat('d.m.Y', $text);
            } catch (Throwable $exception) {
                Telegram::bot('transferBot')->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Неверный формат даты. Нужно отправить в формате ДД.ММ.ГГГГ.',
                ]);

                return;
            }

            $request->update([
                'start_at' => $date,
            ]);

            Telegram::bot('transferBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Введите количество пассажиров',
            ]);

            return;
        }

        if (! $request->passengers_count) {
            if (! $passengers_count = intval($text)) {
                Telegram::bot('transferBot')->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Неверный формат числа. Укажите целое число.',
                ]);

                return;
            }

            $request->update([
                'passengers_count' => $passengers_count,
            ]);
        }

        if (! $user->phone) {
            $phone = new PhoneNumber($text, 'ru');

            if (! $phone->isValid()) {
                Telegram::bot('transferBot')->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Неверно указан телефон. Укажите ваш контактный телефон в формате +7XXXXXXXXXX',
                ]);

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
                $user = $oldUser;
            } else {
                $user->update([
                    'phone' => $phone,
                ]);
            }
        }

        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => '/start',
                    'callback_data' => RequestTypeEnum::PUSH_START->value,
                ]),
            ]);

        Telegram::bot('transferBot')->sendMessage([
            'chat_id' => $chatId,
            'text' => "Спасибо, $user->name! \n В ближайшее время с вами свяжутся по телефону: $user->phone",
            'reply_markup' => $keyboard,
        ]);

        $request->update([
            'status' => RequestStatusEnum::PENDING,
        ]);
        NewBotUsageEvent::dispatch($request);
    }
}
