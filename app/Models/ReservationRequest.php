<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReservationRequest\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\ReservationRequest
 *
 * @property string $id
 * @property string $apartment_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property int $guests
 * @property int $children
 * @property int $total_guests
 * @property int $range
 * @property int $price
 * @property Status|null $status
 * @property string|null $status_text
 * @property string|null $reservation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Reservation|null $reservation
 * @property-read \App\Models\User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereApartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereStatusText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereTotalGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReservationRequest whereUserId($value)
 *
 * @property-read \App\Models\Apartment|null $apartment
 *
 * @mixin \Eloquent
 */
final class ReservationRequest extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'status' => Status::class,
    ];

    public static function calculateFirstPayment(int $price): int
    {
        return intval(ceil($price * 0.3));
    }

    public static function createFromArray(array $data, Apartment $apartment): Model
    {
        $start = Carbon::parse(Arr::get($data, 'start'))
            ->setTime(15, 0);
        $end = Carbon::parse(Arr::get($data, 'end'))->subDay()
            ->setTime(12, 0);

        $price = $apartment->getPriceForRange($start, $end);
        $first_payment = ReservationRequest::calculateFirstPayment($price);

        $data = [
            'start' => $start,
            'end' => $end,
            'apartment_id' => Arr::get($data, 'apartment_id'),
            'user_id' => Arr::get($data, 'user_id'),
            'guests' => Arr::get($data, 'guests'),
            'children' => Arr::get($data, 'children'),
            'total_guests' => Arr::get($data, 'total_guests'),
            'range' => Arr::get($data, 'range'),
            'price' => $price,
            'first_payment' => $first_payment,
            'status' => Status::Pending,
        ];
        Log::info(__METHOD__.json_encode($data));

        return self::query()->firstOrCreate($data);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reject(?string $status_text = null): bool
    {
        $this->status_text = $status_text;
        $this->status = Status::Rejected;

        return $this->save();
    }

    public function submit(Reservation $reservation): bool
    {
        $this->status = Status::Submitted;
        $this->reservation_id = $reservation->id;

        return $this->save();
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
