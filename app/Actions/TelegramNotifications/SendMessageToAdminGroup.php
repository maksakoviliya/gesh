<?php

declare(strict_types=1);

namespace App\Actions\TelegramNotifications;

use App\Filament\Resources\ReservationRequestResource;
use App\Models\ReservationRequest;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

class SendMessageToAdminGroup
{
    public function sendNewReservationRequestMessage(ReservationRequest $reservationRequest): void
    {
        try {
            $text = "Новый запрос на бронирование! \n";
            $text .= 'Даты: ' . $reservationRequest->start->format('d.m.Y') . ' - ' . $reservationRequest->end->format('d.m.Y') . "\n";
            $text .= 'Гости: ' .  $reservationRequest->total_guests;

            $url = ReservationRequestResource::getUrl(
                'edit',
                [
                    'record' => $reservationRequest->id
                ]);
            $button = Keyboard::make(
                [
                    'inline_keyboard' => [
                        [
                            Keyboard::inlineButton(
                                [
                                    'text' => 'К запросу',
                                    'url' => config('app.env') === 'production' ? $url : 'https://google.com'
                                ]
                            )
                        ]
                    ]
                ]
            );

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                "text" => $text,
                'reply_markup' => $button,
            ]);
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                "text" => 'Ошибка при отправке уведомления о новом запросе!' . "/n" . $exception->getMessage(),
            ]);
        }
    }
}
