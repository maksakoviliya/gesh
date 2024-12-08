<?php

declare(strict_types=1);

namespace App\Commands\Transfer;

use App\Enums\Transfer\RequestTypeEnum;
use App\Services\Transfer\TelegramService;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

final class StartCommand extends Command
{
    protected string $name = 'start';

    protected array $aliases = [
        'new',
    ];

    public bool $in_menu = true;

    protected string $description = 'Отправить новый запрос на трансфер';

    public function __construct(
        protected TelegramService $telegramService,
    ) {}

    public function handle(): void
    {
        $update = $this->getUpdate();

        Log::info(__METHOD__.' : '.$update->objectType());

        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $user = $this->telegramService->getUserFromUpdateData($update);
        if (! $user) {
            return;
        }
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

        $this->replyWithMessage([
            'text' => "Привет, $user->name!\nВыберите необходимую услугу:",
            'reply_markup' => $keyboard,
        ]);

    }
}
