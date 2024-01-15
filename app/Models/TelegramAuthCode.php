<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Laravel\Facades\Telegram;

final class TelegramAuthCode extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at'
    ];

    public static function processCode(int|string $code, string $chat_id): User|null
    {
        $auth_code = TelegramAuthCode::query()
            ->where('code', $code)
            ->where('chat_id', $chat_id)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        if (!$auth_code) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Некорректный код. Попробуйте еще раз',
            ]);
            return null;
        }
        $user = User::query()
            ->where('id', $auth_code->user_id)
            ->first();
        if (!$user) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Некорректный код. Попробуйте еще раз',
            ]);
            return null;
        }
        $user->telegramAuthCodes()->delete();
        $user->update([
            'telegram_chat_id' => $chat_id
        ]);
        return $user;
    }
}
