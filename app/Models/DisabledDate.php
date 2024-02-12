<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DisabledDate
 *
 * @property int $id
 * @property string $apartment_id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisabledDate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class DisabledDate extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'date' => 'datetime:d.m.Y H:i',
        'start' => 'datetime:d.m.Y H:i',
        'end' => 'datetime:d.m.Y H:i',
    ];
}
