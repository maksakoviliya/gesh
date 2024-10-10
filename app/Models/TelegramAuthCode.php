<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * App\Models\TelegramAuthCode
 *
 * @property int $id
 * @property string $code
 * @property string $user_id
 * @property string $chat_id
 * @property string $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramAuthCode whereUserId($value)
 *
 * @mixin \Eloquent
 */
final class TelegramAuthCode extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];

    public static function processCode(int|string $code, string $chat_id): ?User
    {
        $auth_code = TelegramAuthCode::query()
            ->where('code', $code)
            ->where('chat_id', $chat_id)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        if (! $auth_code) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Некорректный код. Попробуйте еще раз',
            ]);

            return null;
        }
        $user = User::query()
            ->where('id', $auth_code->user_id)
            ->first();
        if (! $user) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Некорректный код. Попробуйте еще раз',
            ]);

            return null;
        }
        $user->telegramAuthCodes()->delete();
        $user->update([
            'telegram_chat_id' => $chat_id,
        ]);

        return $user;
    }
}
