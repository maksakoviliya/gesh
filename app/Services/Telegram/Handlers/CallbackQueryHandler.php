<?php

namespace App\Services\Telegram\Handlers;

use App\Services\Telegram\UpdateExtractor;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Objects\Update;
use Throwable;

readonly class CallbackQueryHandler {
	public function __construct(
		private UpdateExtractor $extractor,
		// Здесь инжектируем ваши существующие сервисы
		private \App\Services\Telegram\CallBackQueryService $legacyService,
	) {}

	public function handle(Update $update): void
	{
		try {
			$callbackQuery = $update->callbackQuery;

			if (!$callbackQuery) {
				Log::warning('No callback query in update');
				return;
			}

			Log::debug('Processing callback query', [
				'data' => $callbackQuery->data,
				'user_id' => $callbackQuery->from->id,
			]);

			// Временно используем старый сервис для обратной совместимости
			$this->legacyService->process($callbackQuery->toArray());

		} catch (Throwable $e) {
			Log::error('Callback query handler error', [
				'error' => $e->getMessage(),
				'update_id' => $update->updateId,
			]);
		}
	}
}