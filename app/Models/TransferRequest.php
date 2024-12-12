<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Transfer\ButtonDataEnum;
use App\Enums\Transfer\DestinationEnum;
use App\Enums\Transfer\RequestStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TransferRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_at',
        'passengers_count',
        'status',
        'destination',
        'start_time',
    ];

    protected $casts = [
        'status' => RequestStatusEnum::class,
        'type' => ButtonDataEnum::class,
        'start_at' => 'datetime',
        'destination' => DestinationEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
