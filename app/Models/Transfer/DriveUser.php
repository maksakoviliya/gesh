<?php

declare(strict_types=1);

namespace App\Models\Transfer;

use App\Enums\Transfer\DriveUserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

final class DriveUser extends Pivot
{
    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'status' => DriveUserStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function regularDrive(): BelongsTo
    {
        return $this->belongsTo(RegularDrive::class, 'drive_id');
    }
}
