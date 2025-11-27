<?php

declare(strict_types=1);

namespace App\Services\Telegram\Handlers;

use Log;
use Telegram\Bot\Objects\Update;
use Throwable;

class CommandHandler {
	public function handle(Update $update): void
	{
		try {
			$message = $update->message;
			$text = $message?->text ?? '';

			Log::debug('Processing command', [
				'text' => $text,
				'chat_id' => $message?->chat->id,
			]);

			// Команды обрабатываются через commandsHandler в контроллере
			// Этот метод можно использовать для дополнительной логики

		} catch (Throwable $e) {
			Log::error('Command handler error', [
				'error' => $e->getMessage(),
				'update_id' => $update->updateId,
			]);
		}
	}
}