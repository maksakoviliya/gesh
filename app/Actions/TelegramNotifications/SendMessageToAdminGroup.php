<?php

declare(strict_types=1);

namespace App\Actions\TelegramNotifications;

use App\Filament\Resources\ApartmentResource;
use App\Filament\Resources\ReservationRequestResource;
use App\Filament\Resources\ReservationResource;
use App\Filament\Resources\TransferRequestResource;
use App\Filament\Resources\UserResource;
use App\Models\ContactRequest;
use App\Models\Instructor;
use App\Models\Reservation;
use App\Models\ReservationRequest;
use App\Models\Transfer\DriveUser;
use App\Models\TransferRequest;
use App\Services\Transfer\RegularDriveService;
use Exception;
use Log;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Throwable;

class SendMessageToAdminGroup
{
    public function sendNewReservationRequestMessage(ReservationRequest $reservationRequest): void
    {
        try {
            $text = "*Новый запрос на бронирование!* \n\n";
            $text .= 'Объект: '.$this->processText($reservationRequest->apartment->city.', '.$reservationRequest->apartment->street.', '.$reservationRequest->apartment->building)."\n";
            $text .= 'Гость: '.$this->processText($reservationRequest->user->name);
            if ($reservationRequest->user->email) {
                $text .= ', '.'('.$this->processText($reservationRequest->user->email).')';
            }
            if ($reservationRequest->user->phone) {
                $text .= ', '.'('.$this->processText($reservationRequest->user->phone->formatE164()).')';
            }
            $text .= "\n";
            $text .= 'Владелец: '.$this->processText($reservationRequest->apartment->user->name);
            if ($reservationRequest->apartment->user->email) {
                $text .= ', '.'('.$this->processText($reservationRequest->apartment->user->email).')';
            }
            if ($reservationRequest->apartment->user->phone) {
                $text .= ', '.'('.$this->processText($reservationRequest->apartment->user->phone->formatE164()).')';
            }
            $text .= "\n";
            $text .= 'Даты: '.$reservationRequest->start->format('d\.m\.Y').' - '.$reservationRequest->end->format('d\.m\.Y')."\n";

            $text .= 'Цена: '.$reservationRequest->price.', Первоначальный платеж: '.$reservationRequest->first_payment."\n";

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
        } catch (Exception $exception) {
            $this->processException($exception);
        }
    }

    public function sendReservationRequestRejectedMessage(ReservationRequest $reservationRequest): void
    {
        try {
            $text = "*Отказ в запросе на бронирование!* \n\n";
            $text .= 'Причина: '.$reservationRequest->status_text."\n";
            $text .= 'Объект: '.$reservationRequest->apartment->city.', '.$reservationRequest->apartment->street.', '.$reservationRequest->apartment->building."\n";
            $text .= 'Гость: '.$reservationRequest->user->name;
            if ($reservationRequest->user->email) {
                $text .= ', '.'('.$reservationRequest->user->email.')';
            }
            if ($reservationRequest->user->phone) {
                $text .= ', '.'('.$reservationRequest->user->phone->formatE164().')';
            }
            $text .= "\n";
            $text .= 'Владелец: '.$reservationRequest->apartment->user->name;
            if ($reservationRequest->apartment->user->email) {
                $text .= ', '.'('.$reservationRequest->apartment->user->email.')';
            }
            if ($reservationRequest->apartment->user->phone) {
                $text .= ', '.'('.$reservationRequest->apartment->user->phone->formatE164().')';
            }
            $text .= "\n";
            $text .= 'Даты: '.$reservationRequest->start->format('d\.m\.Y').' - '.$reservationRequest->end->format('d\.m\.Y')."\n";

            $text .= 'Цена: '.$reservationRequest->price.', Первоначальный платеж: '.$reservationRequest->first_payment."\n";

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
                'text' => $this->processText($text),
                'reply_markup' => $button,
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception, 'ID: '.$reservationRequest->id);
        }
    }

    public function sendReservationRequestSubmittedMessage(ReservationRequest $reservationRequest, Reservation $reservation): void
    {
        try {
            $text = "*Запрос на бронирование подтвержден!* \n*Новое бронирование создано!* \n\n";

            $text .= 'Объект: '.$reservationRequest->apartment->city.', '.$reservationRequest->apartment->street.', '.$reservationRequest->apartment->building."\n";
            $text .= 'Гость: '.$reservationRequest->user->name;
            if ($reservationRequest->user->email) {
                $text .= ', '.'('.$reservationRequest->user->email.')';
            }
            if ($reservationRequest->user->phone) {
                $text .= ', '.'('.$reservationRequest->user->phone->formatE164().')';
            }
            $text .= "\n";
            $text .= 'Владелец: '.$reservationRequest->apartment->user->name;
            if ($reservationRequest->apartment->user->email) {
                $text .= ', '.'('.$reservationRequest->apartment->user->email.')';
            }
            if ($reservationRequest->apartment->user->phone) {
                $text .= ', '.'('.$reservationRequest->apartment->user->phone->formatE164().')';
            }
            $text .= "\n";
            $text .= 'Даты: '.$reservationRequest->start->format('d\.m\.Y').' - '.$reservationRequest->end->format('d\.m\.Y')."\n";

            $text .= 'Цена: '.$reservationRequest->price.', Первоначальный платеж: '.$reservationRequest->first_payment."\n";

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
            $reservation_url = ReservationResource::getUrl(
                'edit',
                [
                    'record' => $reservation->id,
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
                                    'text' => 'Запрос',
                                    'url' => config('app.env') === 'production' ? $url : 'https://google.com',
                                ]
                            ),
                            Keyboard::inlineButton(
                                [
                                    'text' => 'Бронирование',
                                    'url' => config('app.env') === 'production' ? $reservation_url : 'https://google.com',
                                ]
                            ),
                        ],
                    ],
                ]
            );
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $this->processText($text),
                'reply_markup' => $button,
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception);
        }
    }

    public function sendNewTransferRequestMessage(string $name, string $phone): void
    {
        try {
            $text = "*Новый запрос на трансфер!* \n\n";
            $text .= 'Имя: '.$this->processText($name)."\n";
            $text .= 'Телефон: '.$this->processText($phone)."\n";

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception);
        }
    }

    public function sendNewDriveUserBooking(DriveUser $driveUser): void
    {
        try {
            $user = $driveUser->user;
            $regularDriveService = new RegularDriveService;

            $text = "*Новое бронирование трансфера!* \n\n";
            $text .= 'Маршрут: '.$this->processText($driveUser->regularDrive->name)."\n\n";
            $text .= 'Откуда: '.$this->processText($driveUser->regularDrive->start_point)."\n";
            $text .= 'Куда: '.$this->processText($driveUser->regularDrive->finish_point)."\n\n";
            $text .= 'Дата: '.$driveUser->start_at->format('d.m.Y')."\n";
            $text .= 'Время: '.$this->processText($driveUser->regularDrive->start_at->format('H:i'))."\n\n";
            $text .= 'Мест: '.$driveUser->seats_count."\n";
            $text .= 'Осталось мест: '.$regularDriveService->getAvailableSeatsForDay($driveUser->regularDrive, $driveUser->start_at)."\n\n";
            $text .= 'Имя: '.$this->processText($user->name)."\n";
            $text .= 'Телефон: '.$user->phone?->formatE164()."\n";

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception);
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
                'text' => $this->processText($text),
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception);
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
                $text .= ', '.'('.$reservation->user->phone->formatE164().')';
            }
            $text .= "\n";
            $text .= 'Владелец: '.$reservation->apartment->user->name;
            if ($reservation->apartment->user->email) {
                $text .= ', '.'('.$reservation->apartment->user->email.')';
            }
            if ($reservation->apartment->user->phone) {
                $text .= ', '.'('.$reservation->apartment->user->phone->formatE164().')';
            }
            $text .= "\n";
            $text .= 'Даты: '.$reservation->start->format('d\.m\.Y').' - '.$reservation->end->format('d\.m\.Y')."\n";

            $text .= 'Цена: '.$reservation->price.', Первоначальный платеж: '.$reservation->first_payment."\n";

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
                'text' => $this->processText($text),
                'reply_markup' => $button,
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception);
        }
    }

    protected function processException(Throwable $exception, string $additionalText = ''): void
    {
        Log::info($exception->getMessage());
        Log::info($exception->getFile());
        Log::info($exception->getLine());

        Telegram::sendMessage([
            'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
            'text' => 'Ошибка при отправке уведомления!'."\n\n".$exception->getMessage().$additionalText."\n\n".__METHOD__,
        ]);
    }

    protected function processText(?string $text = null): string
    {
        if (! $text) {
            return '';
        }

        return str_replace(['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '-', '=', '|', '{', '}', '.', '!'], ['\_', '\*', '\[', '\]', '\(', '\)', '\~', '\`', '\>', '\#', '\+', '\-', '\=', '\|', '\{', '\}', '\.', '\!'], $text);
    }

    public function sendNewTelegramTransferRequest(TransferRequest $transferRequest): void
    {
        try {
            $text = "*Новый запрос на трансфер через телеграм бота!* \n\n";
            $text .= 'Тип: '.__('transfer.type.'.$transferRequest->type->value)."\n";
            $text .= 'Направление: '.__('transfer.destination.'.$transferRequest->destination->value)."\n";
            $text .= 'Дата: '.$transferRequest->start_at->format('d.m.Y')."\n";
            $text .= 'Время: '.$transferRequest->start_time."\n";
            $text .= 'Пассажиры: '.$transferRequest->passengers_count."\n";
            $text .= 'Пользователь: '.$this->processText($transferRequest->user->name)."\n";
            $text .= 'Телеграм: @'.$this->processText($transferRequest->user->telegram_username)."\n";
            $text .= $transferRequest->user->phone ? 'Телефон: '.$this->processText($transferRequest->user->phone->formatE164()) : '-';

            $request_url = TransferRequestResource::getUrl(
                'edit',
                [
                    'record' => $transferRequest->id,
                ]);
            $keyboard = Keyboard::make()
                ->inline()
                ->row([
                    Keyboard::inlineButton([
                        'text' => 'К запросу',
                        'url' => config('app.env') === 'production' ? $request_url : 'https://google.com',
                    ]),
                ]);

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $text,
                'reply_markup' => $keyboard,
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception);
        }
    }

    public function sendNewContactRequest(ContactRequest $contactRequest): void
    {
        try {
            $text = "*Новый запрос на контакты собственника!* \n\n";
            $text .= 'Объект: '.$this->processText($contactRequest->apartment->city.', '.$contactRequest->apartment->street.', '.$contactRequest->apartment->building)."\n";
            $text .= 'Имя: '.$this->processText($contactRequest->name)."\n";
            $text .= 'Телефон: '.$this->processText($contactRequest->phone->formatE164())."\n";
            if ($contactRequest->telegram_username) {
                $text .= 'Телеграм: @'.$this->processText($contactRequest->telegram_username)."\n";
            }

            $buttons = [
                'inline_keyboard' => [
                    [
                        Keyboard::inlineButton(
                            [
                                'text' => 'Объект',
                                'url' => config('app.env') === 'production' ? ApartmentResource::getUrl(
                                    'edit',
                                    [
                                        'record' => $contactRequest->apartment->id,
                                    ]) : 'https://google.com',
                            ]
                        ),
                    ],
                ],
            ];
            $owner_url = UserResource::getUrl(
                'edit',
                [
                    'record' => $contactRequest->apartment->user->id,
                ]);

            $guest_url = $contactRequest->user_id ? UserResource::getUrl(
                'edit',
                [
                    'record' => $contactRequest->user_id,
                ]) : null;

            $buttons['inline_keyboard'][] = $guest_url ? [
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
            ] : [
                Keyboard::inlineButton(
                    [
                        'text' => 'Владелец',
                        'url' => config('app.env') === 'production' ? $owner_url : 'https://google.com',
                    ]
                ),
            ];

            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
                'text' => $text,
                'reply_markup' => Keyboard::make(
                    $buttons
                ),
                'parse_mode' => 'Markdown',
            ]);
        } catch (Exception $exception) {
            $this->processException($exception);
        }
    }
}
