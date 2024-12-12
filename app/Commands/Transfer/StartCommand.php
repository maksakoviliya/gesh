<?php

declare(strict_types=1);

namespace App\Commands\Transfer;

use App\Services\Transfer\TelegramService;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

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

        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $user = $this->telegramService->getUserFromUpdateData($update);
        if (! $user) {
            Log::error('User not found: '.__METHOD__);

            return;
        }
        $chatId = $update->getMessage()->getChat()->getId();
        if (! $chatId) {
            Log::error('Chat not found: '.__METHOD__);

            return;
        }
        $this->telegramService->sendStartMessage($chatId, $user);
    }
}
