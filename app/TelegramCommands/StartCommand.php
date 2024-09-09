<?php

namespace App\TelegramCommands;

use App\Models\User;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';

    protected array $aliases = ['join'];

    protected string $description = 'Start Command to get you started';

    public bool $in_menu = false;

    public function handle(): void
    {
        $chat_id = $this->getUpdate()->getChat()->id;

        $user = User::query()
            ->where('telegram_chat_id', $chat_id)
            ->first();

        if (! $user) {
            $this->replyWithMessage([
                'text' => 'Добрый день!',
            ]);

            $this->replyWithMessage([
                'text' => 'Чтобы начать пользоваться ботом введите ваш номер телефона в формате +7##########, который привязан к вашему аккаунту на сайте.',
            ]);
        } else {
            $this->replyWithMessage([
                'text' => "{$user->name}, добрый день!",
            ]);
        }
    }
}
