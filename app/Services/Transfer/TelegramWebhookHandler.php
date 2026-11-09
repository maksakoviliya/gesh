<?php

declare(strict_types=1);

namespace App\Services\Transfer;

use App\Services\Transfer\Conversation\ConversationManager;
use App\Services\Transfer\Handlers\CallbackHandler;
use App\Services\Transfer\Handlers\CommandHandler;
use App\Services\Transfer\Handlers\ContactHandler;
use App\Services\Transfer\Handlers\MessageHandler;
use App\Services\Transfer\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\Update;
use Throwable;

final readonly class TelegramWebhookHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private CommandHandler $commandHandler,
        private CallbackHandler $callbackHandler,
        private MessageHandler $messageHandler,
        private ContactHandler $contactHandler,
        private ConversationManager $conversationManager,
    ) {}

    public function handle(Update $update): void
    {
        $chatId = null;

        // Never let an exception escape: a 500 makes Telegram resend the same update forever and the bot stalls.
        try {
            $user = $this->userRepository->findOrCreateFromUpdate($update);
            if (! $user) {
                // edited_message, my_chat_member etc. — nothing to do
                Log::info('Skipping unsupported update', ['update_id' => $update->updateId]);

                return;
            }

            $chatId = $this->extractChatId($update);
            if (! $chatId) {
                Log::error('Cannot extract chat_id from update', ['update_id' => $update->updateId]);

                return;
            }

            // Callback first: getMessage() of a callback is the bot's own message, which may contain "/start".
            if ($this->isCallback($update)) {
                $this->callbackHandler->handle($update, $user, $chatId);
            } elseif ($this->isCommand($update)) {
                $this->commandHandler->handle($update, $user, $chatId);
            } elseif ($this->isContact($update)) {
                $this->contactHandler->handle($update, $user, $chatId);
            } elseif ($this->isMessage($update)) {
                $this->messageHandler->handle($update, $user, $chatId);
            }
        } catch (Throwable $e) {
            Log::error('Error processing update', [
                'update_id' => $update->updateId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($chatId) {
                $this->conversationManager->sendError($chatId);
            }
        }
    }

    private function extractChatId(Update $update): ?int
    {
        return $update->getMessage()?->getChat()?->getId()
            ?? $update->callbackQuery?->message?->chat?->id;
    }

    private function isCommand(Update $update): bool
    {
        $entities = $update->getMessage()?->get('entities');

        return $entities && ($entities[0]['type'] ?? null) === 'bot_command';
    }

    private function isCallback(Update $update): bool
    {
        return $update->callbackQuery !== null;
    }

    private function isContact(Update $update): bool
    {
        return $update->getMessage()?->contact !== null;
    }

    private function isMessage(Update $update): bool
    {
        return $update->getMessage()?->text !== null;
    }
}
