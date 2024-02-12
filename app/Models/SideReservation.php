<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SideReservation
 *
 * @property string $id
 * @property string $apartment_id
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property string|null $description
 * @property string|null $summary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Apartment|null $apartment
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SideReservation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class SideReservation extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'start' => 'datetime:d.m.Y H:i',
        'end' => 'datetime:d.m.Y H:i',
    ];

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
