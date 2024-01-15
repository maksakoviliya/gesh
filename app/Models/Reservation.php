<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Reservation\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Reservation
 *
 * @property string $id
 * @property string $user_id
 * @property string $apartment_id
 * @property string|null $reservation_request_id
 * @property string $start
 * @property string $end
 * @property int $guests
 * @property int $children
 * @property int $total_guests
 * @property int $range
 * @property int $price
 * @property Status $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Apartment|null $apartment
 * @property-read \App\Models\User|null $user
 *
 * @method static Builder|Reservation newModelQuery()
 * @method static Builder|Reservation newQuery()
 * @method static Builder|Reservation query()
 * @method static Builder|Reservation whereApartmentId($value)
 * @method static Builder|Reservation whereChildren($value)
 * @method static Builder|Reservation whereCreatedAt($value)
 * @method static Builder|Reservation whereEnd($value)
 * @method static Builder|Reservation whereGuests($value)
 * @method static Builder|Reservation whereId($value)
 * @method static Builder|Reservation wherePrice($value)
 * @method static Builder|Reservation whereRange($value)
 * @method static Builder|Reservation whereReservationRequestId($value)
 * @method static Builder|Reservation whereStart($value)
 * @method static Builder|Reservation whereStatus($value)
 * @method static Builder|Reservation whereTotalGuests($value)
 * @method static Builder|Reservation whereUpdatedAt($value)
 * @method static Builder|Reservation whereUserId($value)
 *
 * @mixin \Eloquent
 */
final class Reservation extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'status' => Status::class,
        'start' => 'date:d.m.Y',
        'end' => 'date:d.m.Y',
    ];

    protected $with = [
        'user',
        'apartment',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    public static function createFromReservationRequest(ReservationRequest $reservationRequest): Model|Builder
    {
        $reservation = Reservation::query()
            ->create([
                'user_id' => $reservationRequest->user_id,
                'apartment_id' => $reservationRequest->apartment_id,
                'reservation_request_id' => $reservationRequest->id,
                'start' => $reservationRequest->start,
                'end' => $reservationRequest->end,
                'guests' => $reservationRequest->guests,
                'children' => $reservationRequest->children,
                'total_guests' => $reservationRequest->total_guests,
                'range' => $reservationRequest->range,
                'price' => $reservationRequest->price,
            ]);

        return $reservation;
    }

    public function setStatus(Status $status): bool
    {
        $this->status = $status;

        return $this->save();
    }

    public function getFirstPaymentAmount(): int
    {
        $totalPrice = ceil($this->price * 1.15);

        return (int) ceil($totalPrice * 0.3);
    }

    public function getPaymentDescription(): string
    {
        return "Бронирование #{$this->id}. C {$this->start->format('d.m.Y')} по {$this->end->format('d.m.Y')}";
    }
}
