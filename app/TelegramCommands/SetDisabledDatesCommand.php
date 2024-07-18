<?php

declare(strict_types=1);

namespace App\TelegramCommands;

use App\Models\Apartment;
use App\Models\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

final class SetDisabledDatesCommand extends Command
{
    protected string $name = 'dates';

    protected string $description = 'Set disabled dates for one of your apartments';

    public bool $in_menu = true;

    public function handle()
    {
        $chat_id = $this->getUpdate()->getChat()->id;

        $user = User::query()
            ->where('telegram_chat_id', $chat_id)
            ->first();

        if (! $user) {
            $this->replyWithMessage([
                'text' => 'Пользователь не найден. Попробуйте зарегистрироваться через бота.',
            ]);
        }

        $apartments = Apartment::query()
            ->where('user_id', $user->id)
            ->published()
            ->order()
            ->get();

        $reply_markup = Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);

        foreach ($apartments as $apartment) {
            $reply_markup = $reply_markup->row([
                Keyboard::inlineButton([
                    'text' => $apartment->full_address,
                    'callback_data' => $apartment->id
                ]),
            ]);
        }

        Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Hello World',
            'reply_markup' => $reply_markup,
        ]);
    }
}
