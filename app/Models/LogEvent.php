<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LogEvents\NamesEnum as LogEventNamesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class LogEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'data_before',
        'data_after',
        'eventable_type',
        'eventable_id',
    ];

    protected $casts = [
        'name' => LogEventNamesEnum::class,
        'data_before' => 'array',
        'data_after' => 'array',
    ];
}
