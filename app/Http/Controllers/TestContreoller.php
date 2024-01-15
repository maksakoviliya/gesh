<?php

namespace App\Http\Controllers;

use App\Filament\Resources\ReservationRequestResource;
use App\Models\ReservationRequest;
use App\Models\TelegramAuthCode;
use App\TelegramCommands\StartCommand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Telegram;
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class TestContreoller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $code = '9758';

        $chat_id = 381110669;
        $code = TelegramAuthCode::query()
            ->where('code', $code)
            ->where('chat_id', $chat_id)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        dd($code);
        $commands = Telegram::getCommands();
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->setMyCommands([
            'commands' => [
                (object) [
                    'command' => 'help',
                    'description' => 'Help command',
                ],
                (object) [
                    'command' => 'start',
                    'description' => 'Начать',
                ],
            ],
        ]);
        //        $res = Telegram::addCommand(StartCommand::class);
        dd($telegram);
        //        $response = Telegram::bot()->getMe();
        //        dd($response);
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
