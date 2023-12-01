<?php

declare(strict_types=1);

namespace App\Models\Chat;

use App\Models\ReservationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at'
    ];

    protected $with = [
        'user'
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
