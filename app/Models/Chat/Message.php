<?php

declare(strict_types=1);

namespace App\Models\Chat;

use App\Models\ReservationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

/**
 * App\Models\Chat\Message
 *
 * @property int $id
 * @property string $user_id
 * @property string $chat_id
 * @property string|null $reservation_request_id
 * @property string|null $message
 * @property string|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ReservationRequest|null $reservation_request
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereReservationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereUserId($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $with = [
        'user',
    ];

    protected $casts = [
        'created_at' => 'datetime:H:m',
    ];

    public static function createFromArray(array $data): Model
    {
        return static::query()
            ->create([
                'user_id' => Arr::get($data, 'user_id'),
                'chat_id' => Arr::get($data, 'chat_id'),
                'reservation_request_id' => Arr::get($data, 'reservation_request_id'),
                'message' => Arr::get($data, 'message'),
            ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservation_request(): BelongsTo
    {
        return $this->belongsTo(
            related: ReservationRequest::class,
            foreignKey: 'reservation_request_id'
        );
    }
}
