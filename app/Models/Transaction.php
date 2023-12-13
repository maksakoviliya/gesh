<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Transactions\Status;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $reservation_id
 * @property int $amount
 * @property string $user_id
 * @property Status $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereReservationId($value)
 * @method static Builder|Transaction whereStatus($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction whereUserId($value)
 * @mixin Eloquent
 */
final class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public static function createForReservation(Reservation $reservation): Model|Builder
    {
        return Transaction::query()
            ->create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->price,
                'user_id' => Auth::id(),
            ]);
    }
}
