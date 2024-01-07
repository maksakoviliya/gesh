<?php

namespace App\Http\Controllers;

use App\Filament\Resources\ReservationRequestResource;
use App\Models\ReservationRequest;
use Illuminate\Http\Request;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

class TestContreoller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //        $url = ReservationRequestResource::getUrl(
        //            'edit',
        //            [
        //                'record' => ReservationRequest::query()->first()
        //            ]);
//        dd(Telegram::getUpdates());
//        $url = 'https://google.com';
//        $url2 = 'https://yandex.ru';
//
//        $button = Keyboard::make([
//            'inline_keyboard' => [
//                [
//                    Keyboard::inlineButton([
//                        'text' => 'Перейти на Google',
//                        'url' => $url,
//                    ]),
//                    Keyboard::inlineButton([
//                        'text' => 'Перейти на Яндекс',
//                        'url' => $url2,
//                    ]),
//
//                ],
//            ],
//        ]);
//
//        Telegram::sendMessage([
//            'chat_id' => config('telegram.bots.GeshResortBot.chat_id'),
//            'text' => "Click to Open\n\nА тут еще текст",
//        ]);
    }
}
