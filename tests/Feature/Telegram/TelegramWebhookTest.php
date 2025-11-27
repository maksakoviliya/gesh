<?php

namespace Tests\Feature\Telegram;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TelegramWebhookTest extends TestCase
{
	use RefreshDatabase;

	public function test_webhook_accepts_valid_update(): void
	{
		$response = $this->postJson(sprintf("/%s/webhook", env('TELEGRAM_BOT_TOKEN')), [
			'update_id' => 123456,
			'message' => [
				'message_id' => 1,
				'from' => [
					'id' => 12345,
					'first_name' => 'John',
					'username' => 'john_doe',
				],
				'chat' => [
					'id' => 12345,
					'type' => 'private',
				],
				'text' => 'Hello',
			],
		]);

		$response->assertOk();
		$response->assertJson(['ok' => true]);
	}

	public function test_webhook_rejects_invalid_request(): void
	{
		$response = $this->postJson(sprintf("/%s/webhook", env('TELEGRAM_BOT_TOKEN')), [
			'invalid' => 'data',
		]);

		$response->assertStatus(200);
	}
}
