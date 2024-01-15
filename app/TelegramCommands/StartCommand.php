<?php

namespace App\TelegramCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected array $aliases = ['join'];
    protected string $description = 'Start Command to get you started';

    public function handle(): void
    {
        $this->replyWithMessage([
            'text' => "Добрый день!"
        ]);

        $this->replyWithMessage([
            'text' => 'Чтобы начать полльзоваться ботом введите ваш номер телефона в формате +7##########, который привязан к вашему аккаунту на сайте.'
        ]);

        \Log::info(json_encode($this->update));
    }
}
