<?php

declare(strict_types=1);

namespace App\Actions\TelegramNotifications;

use App\Filament\Resources\ApartmentResource;
use App\Filament\Resources\ReservationRequestResource;
use App\Filament\Resources\UserResource;
use App\Models\Instructor;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

class SendMessageToAdminGroup
{
    public function sendNewReservationRequestMessage(ReservationRequest $reservationRequest): void
    {
        try {
            $text = "*Новый запрос на бронирование!* \n\n";
            $text .= 'Объект: '.$reservationRequest->apartment->city.', '.$reservationRequest->apartment->street.', '.$reservationRequest->apartment->building."\n";
            $text .= 'Гость: '.$reservationRequest->user->name;
            if ($reservationRequest->user->email) {
                $text .= ', '.'('.$reservationRequest->user->email.')';
            }
            if ($reservationRequest->user->phone) {
                $text .= ', '.'('.$reservationRequest->user->phone.')';
            }
            $text .= "\n";
            $text .= 'Владелец: '.$reservationRequest->apartment->user->name;
            if ($reservationRequest->apartment->user->email) {
                $text .= ', '.'('.$reservationRequest->apartment->user->email.')';
            }
            if ($reservationRequest->apartment->user->phone) {
                $text .= ', '.'('.$reservationRequest->apartment->user->phone.')';
            }
            $text .= "\n";
            $text .= 'Даты: '.$reservationRequest->start->format('d\.m\.Y').' - '.$reservationRequest->end->format('d\.m\.Y')."\n";

            $commission = ReservationRequest::getCommission($reservationRequest->price);
            $text .= 'Цена: '.$reservationRequest->price.', Комиссия: '.$commission.', Итого: '.$reservationRequest->price + $commission."\n";

            $text .= 'Гости: '.$reservationRequest->total_guests."\n";

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
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => 'Ошибка при отправке уведомления о новом запросе!'.'/n/n'.$exception->getMessage(),
            ]);
        }
    }

    public function sendNewTransferRequestMessage(string $name, string $phone): void
    {
        try {
            $text = "*Новый запрос на трансфер!* \n\n";
            $text .= 'Имя: '.$name."\n";
            $text .= 'Телефон: '.$phone."\n";

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => 'Ошибка при отправке уведомления о трансфере!'.'/n/n'.$exception->getMessage(),
            ]);
        }
    }

    public function sendNewInstructorRequestMessage(Instructor $instructor, string $name, string $phone): void
    {
        try {
            $text = "*Новый запрос на инструктора!* \n\n";
            $text .= 'Имя: '.$name."\n";
            $text .= 'Телефон: '.$phone."\n";
            $text .= 'Инструктор: '.$instructor->name."\n";

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => 'Ошибка при отправке уведомления о инструкторе!'.'/n/n'.$exception->getMessage(),
            ]);
        }
    }

    public function sendReservationPaid(Reservation $reservation): void
    {
        try {
            $text = "*Бронирование оплачено!* \n\n";
            $text .= 'Объект: '.$reservation->apartment->city.', '.$reservation->apartment->street.', '.$reservation->apartment->building."\n";
            $text .= 'Гость: '.$reservation->user->name;
            if ($reservation->user->email) {
                $text .= ', '.'('.$reservation->user->email.')';
            }
            if ($reservation->user->phone) {
                $text .= ', '.'('.$reservation->user->phone.')';
            }
            $text .= "\n";
            $text .= 'Владелец: '.$reservation->apartment->user->name;
            if ($reservation->apartment->user->email) {
                $text .= ', '.'('.$reservation->apartment->user->email.')';
            }
            if ($reservation->apartment->user->phone) {
                $text .= ', '.'('.$reservation->apartment->user->phone.')';
            }
            $text .= "\n";
            $text .= 'Даты: '.$reservation->start->format('d\.m\.Y').' - '.$reservation->end->format('d\.m\.Y')."\n";

            $commission = $reservation::getCommission($reservation->price);
            $text .= 'Цена: '.$reservation->price.', Комиссия: '.$commission.', Итого: '.$reservation->price + $commission."\n";

            $text .= 'Гости: '.$reservation->total_guests."\n";

            $url = ReservationRequestResource::getUrl(
                'edit',
                [
                    'record' => $reservation->id,
                ]);

            $object_url = ApartmentResource::getUrl(
                'edit',
                [
                    'record' => $reservation->apartment->id,
                ]);
            $owner_url = UserResource::getUrl(
                'edit',
                [
                    'record' => $reservation->apartment->user->id,
                ]);
            $guest_url = UserResource::getUrl(
                'edit',
                [
                    'record' => $reservation->user_id,
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
                                    'text' => 'К броинрованию',
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
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => 'Ошибка при отправке уведомления о оплате бронирования!'.'/n/n'.$exception->getMessage(),
            ]);
        }
    }
}
