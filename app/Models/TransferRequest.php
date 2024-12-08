<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Transfer\RequestStatusEnum;
use App\Enums\Transfer\RequestTypeEnum;
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
    ];

    protected $casts = [
        'status' => RequestStatusEnum::class,
        'type' => RequestTypeEnum::class,
        'start_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
