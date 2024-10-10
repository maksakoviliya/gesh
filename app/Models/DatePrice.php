<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DatePrice
 *
 * @property int $id
 * @property string $apartment_id
 * @property string $date
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DatePrice whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class DatePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_id',
        'date',
        'price',
    ];
}
