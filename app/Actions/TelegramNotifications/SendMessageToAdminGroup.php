<?php

declare(strict_types=1);

namespace App\Actions\TelegramNotifications;

use App\Filament\Resources\ApartmentResource;
use App\Filament\Resources\ReservationRequestResource;
use App\Filament\Resources\UserResource;
use App\Models\ReservationRequest;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

class SendMessageToAdminGroup
{
    public function sendNewReservationRequestMessage(ReservationRequest $reservationRequest): void
    {
        try {
            $text = "*Новый запрос на бронирование!* \n\n";
            $text .= 'Объект: ' . $reservationRequest->apartment->city . ', ' . $reservationRequest->apartment->street . ', ' . $reservationRequest->apartment->housing . "\n";
            $text .= 'Гость: ' . $reservationRequest->user->name . ', ' . '(' . $reservationRequest->user->email . ')';
            if ($reservationRequest->user->phone) {
                $text .= ', ' . '(' . $reservationRequest->user->phone . ')';
            }
            $text .= "\n";
            $text .= 'Даты: ' . $reservationRequest->start->format('d\.m\.Y') . ' - ' . $reservationRequest->end->format('d\.m\.Y') . "\n";
            $text .= 'Гости: ' . $reservationRequest->total_guests;

            $url = ReservationRequestResource::getUrl(
                'edit',
                [
                    'record' => $reservationRequest->id,
                ]);

            $object_url = ApartmentResource::getUrl(
                'edit',
                [
                    'record' => $reservationRequest->apartment->id,
                ]);
            $owner_url = UserResource::getUrl(
                'edit',
                [
                    'record' => $reservationRequest->apartment->user->id,
                ]);
            $guest_url = UserResource::getUrl(
                'edit',
                [
                    'record' => $reservationRequest->user_id,
                ]);
            $button = Keyboard::make(
                [
                    'inline_keyboard' => [
                        [
                            Keyboard::inlineButton(
                                [
                                    'text' => 'Объект',
                                    'url' => config('app.env') === 'production' ? $object_url : 'https://google.com',
                                ]
                            ),
                        ],
                        [
                            Keyboard::inlineButton(
                                [
                                    'text' => 'Владелец',
                                    'url' => config('app.env') === 'production' ? $owner_url : 'https://google.com',
                                ]
                            ),
                            Keyboard::inlineButton(
                                [
                                    'text' => 'Гость',
                                    'url' => config('app.env') === 'production' ? $guest_url : 'https://google.com',
                                ]
                            ),
                        ],
                        [
                            Keyboard::inlineButton(
                                [
                                    'text' => 'К запросу',
                                    'url' => config('app.env') === 'production' ? $url : 'https://google.com',
                                ]
                            ),
                        ],
                    ],
                ]
            );
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $text,
                'reply_markup' => $button,
                'parse_mode' => 'Markdown'
            ]);
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => 'Ошибка при отправке уведомления о новом запросе!' . "/n/n" . $exception->getMessage(),
            ]);
        }
    }
}
