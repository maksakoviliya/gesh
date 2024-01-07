<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ICalLink
 *
 * @property int $id
 * @property string $apartment_id
 * @property string $link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|ICalLink newModelQuery()
 * @method static Builder|ICalLink newQuery()
 * @method static Builder|ICalLink query()
 * @method static Builder|ICalLink whereApartmentId($value)
 * @method static Builder|ICalLink whereCreatedAt($value)
 * @method static Builder|ICalLink whereId($value)
 * @method static Builder|ICalLink whereLink($value)
 * @method static Builder|ICalLink whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class ICalLink extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
