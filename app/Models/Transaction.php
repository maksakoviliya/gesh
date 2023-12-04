<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Transactions\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at'
    ];

    protected $casts = [
        'status' => Status::class
    ];

    /**
     * @param Reservation $reservation
     * @return Model|Builder
     */
    public static function createForReservation(Reservation $reservation): Model|Builder
    {
        return Transaction::query()
            ->create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->price,
                'user_id' => Auth::id()
            ]);
    }
}
