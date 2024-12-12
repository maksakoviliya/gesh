<?php

declare(strict_types=1);

namespace App\Commands\Invite;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use Throwable;

final class StartCommand extends Command
{
    protected string $name = 'start';

    public bool $in_menu = true;

    protected string $description = 'Отправить приглашение вступить в группу';

    public function handle(): void
    {
        $update = $this->getUpdate();

        Log::debug(__METHOD__.json_encode($update));

        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $chatId = $update->getMessage()->getChat()->getId();
        if (! $chatId) {
            Log::error('Chat not found: '.__METHOD__);

            return;
        }

        $keyboard = Keyboard::make()
            ->inline()
            ->row([
                Keyboard::inlineButton([
                    'text' => 'Перейти в группу',
                    'url' => 'https://t.me/@sheregeshresort',
                ]),
            ]);

        try {
            Telegram::bot('inviteBot')->sendMessage([
                'chat_id' => $chatId,
                'text' => "Привет!\nПерейти в чат Шерегеш",
                'reply_markup' => $keyboard,
            ]);

        } catch (Throwable $exception) {
            Log::error('Error sending message: '.$exception->getMessage());
        }
    }
}
