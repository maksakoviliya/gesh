<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Services\Telegram\Handlers\CallbackQueryHandler;
use App\Services\Telegram\Handlers\CommandHandler;
use App\Services\Telegram\Handlers\Messagehandler;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\Update;

final readonly class TelegramWebhookProcessor
{
	public function __construct(
		private CallbackQueryHandler $callbackHandler,
		private CommandHandler $commandHandler,
		private MessageHandler $messageHandler,
	) {}

	public function process(Update $update): void
	{
		Log::debug('Processing update', [
			'update_id' => $update->updateId,
			'type' => $this->getUpdateType($update),
		]);

		// Приоритет обработки:
		// 1. Callback Query (нажатия на inline-кнопки)
		if ($update->callbackQuery) {
			$this->callbackHandler->handle($update);
			return;
		}

		// 2. Команды бота (начинаются с /)
		if ($this->isCommand($update)) {
			$this->commandHandler->handle($update);
			return;
		}

		// 3. Обычные сообщения
		if ($update->message) {
			$this->messageHandler->handle($update);
			return;
		}

		Log::warning('Unknown update type', [
			'update_id' => $update->updateId,
			'update' => $update->toArray(),
		]);
	}

	private function isCommand(Update $update): bool
	{
		$entities = $update->message?->entities ?? [];

		foreach ($entities as $entity) {
			if ($entity->type === 'bot_command') {
				return true;
			}
		}

		return false;
	}

	private function getUpdateType(Update $update): string
	{
		return match (true) {
			isset($update->message) => 'message',
			isset($update->callbackQuery) => 'callback_query',
			isset($update->editedMessage) => 'edited_message',
			isset($update->channelPost) => 'channel_post',
			isset($update->inlineQuery) => 'inline_query',
			default => 'unknown',
		};
	}
}