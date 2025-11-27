<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Telegram\Bot\Objects\Update;

class UpdateExtractor {
	public function getChatId(Update $update): ?int
	{
		return $update->message?->chat->id
			?? $update->callbackQuery?->message?->chat->id;
	}

	public function getUserId(Update $update): ?int
	{
		return $update->message?->from?->id
			?? $update->callbackQuery?->from?->id;
	}

	public function getText(Update $update): ?string
	{
		return $update->message?->text;
	}

	public function getCallbackData(Update $update): ?string
	{
		return $update->callbackQuery?->data;
	}

	public function getUsername(Update $update): ?string
	{
		return $update->message?->from?->username
			?? $update->callbackQuery?->from?->username;
	}

	public function getFirstName(Update $update): ?string
	{
		return $update->message?->from?->firstName
			?? $update->callbackQuery?->from?->firstName;
	}

	public function getLastName(Update $update): ?string
	{
		return $update->message?->from?->lastName
			?? $update->callbackQuery?->from?->lastName;
	}

	public function getFullName(Update $update): string
	{
		$firstName = $this->getFirstName($update) ?? '';
		$lastName = $this->getLastName($update) ?? '';

		return trim("$firstName $lastName") ?: 'Anonymous';
	}
}