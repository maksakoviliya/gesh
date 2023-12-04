<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Reservation\Status;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Reservation extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [
        'id',
        'created_at'
    ];

    protected $casts = [
        'status' => Status::class
    ];

    protected $with = [
        'user',
        'apartment'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }


    /**
     * @param ReservationRequest $reservationRequest
     * @return Model|Builder
     */
    public static function createFromReservationRequest(ReservationRequest $reservationRequest): Model|Builder
    {
        $reservation =  Reservation::query()
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
        $period = CarbonPeriod::create(
            $reservationRequest->start,
            $reservationRequest->end->subDay(),
        );
        foreach ($period as $date) {
            DisabledDate::query()
                ->create([
                    'apartment_id' => $reservationRequest->apartment_id,
                    'date' => $date,
                ]);
        }
        return $reservation;
    }

    public function setStatus(Status $status): bool
    {
        $this->status = $status;
        return $this->save();
    }
}
