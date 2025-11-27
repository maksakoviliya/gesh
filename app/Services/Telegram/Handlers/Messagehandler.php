<?php

namespace App\Services\Telegram\Handlers;

use App\Enums\Telegram\EntityType;
use App\Services\Telegram\UpdateExtractor;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\Update;
use Throwable;

readonly class Messagehandler {
	public function __construct(
		private UpdateExtractor $extractor,
		// Ваши существующие сервисы
		private \App\Services\Telegram\ProcessTextService $legacyService,
	) {}

	public function handle(Update $update): void
	{
		try {
			$message = $update->message;

			if (!$message) {
				Log::warning('No message in update');
				return;
			}

			$text = $message->text ?? '';
			$chatId = $message->chat->id;
			$messageType = $this->detectMessageType($message);

			Log::debug('Processing message', [
				'type' => $messageType,
				'chat_id' => $chatId,
				'text_length' => strlen($text),
			]);

			// Обработка в зависимости от типа
			match ($messageType) {
				'phone' => $this->legacyService->processPhone($text, $chatId),
				'text' => $this->legacyService->processText($text, $chatId),
				default => Log::warning('Unknown message type', ['type' => $messageType]),
			};

		} catch (Throwable $e) {
			Log::error('Message handler error', [
				'error' => $e->getMessage(),
				'update_id' => $update->updateId,
			]);
		}
	}

	private function detectMessageType($message): string
	{
		$entities = $message->entities ?? [];

		foreach ($entities as $entity) {
			if ($entity->type === EntityType::PhoneNumber->value) {
				return 'phone';
			}
		}

		return 'text';
	}
}