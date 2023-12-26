<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ICalLink
 *
 * @property int $id
 * @property string $apartment_id
 * @property string $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ICalLink whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ICalLink extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];
}
