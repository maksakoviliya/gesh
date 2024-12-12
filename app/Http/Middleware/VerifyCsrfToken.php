<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

final class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'tg_bot_token_123/webhook',
        'telegram_invite/tg_invite_123/webhook',
        'transfer/telegram/tg_transfer_123/webhook',
    ];
}
