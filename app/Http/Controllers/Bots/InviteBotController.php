<?php

declare(strict_types=1);

namespace App\Http\Controllers\Bots;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

final class InviteBotController extends Controller
{
    public function __invoke(Request $request): string
    {
        Log::info(Carbon::now()->format('d.m.Y H:i:s').': '.json_encode($request->all()));

        Telegram::bot('inviteBot')->commandsHandler(true);

        return 'ok';
    }
}
