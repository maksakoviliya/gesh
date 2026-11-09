<?php

declare(strict_types=1);

namespace App\Services\Transfer\Handlers;

use App\Enums\Transfer\RequestStatusEnum;
use App\Models\TransferRequest;
use App\Models\User;
use App\Services\Transfer\Conversation\ConversationManager;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\Update;

final readonly class MessageHandler
{
    public function __construct(
        private ConversationManager $conversationManager,
    ) {}

    public function handle(Update $update, User $user, int $chatId): void
    {
        $text = $update->getMessage()->text;

        /** @var TransferRequest $request */
        $request = TransferRequest::query()
            ->where('user_id', $user->id)
            ->where('status', RequestStatusEnum::DRAFT)
            ->latest('created_at')
            ->first();

        if (! $request) {
            Log::error('No draft request found for message handling', ['user_id' => $user->id]);
            $this->conversationManager->sendError($chatId);

            return;
        }

        $this->conversationManager->processInput($request, $user, $chatId, $text);
    }
}
