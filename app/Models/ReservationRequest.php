<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReservationRequest\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;

final class ReservationRequest extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [
        'id',
        'created_at'
    ];

    protected $casts = [
        'start' => 'date:d.m.Y',
        'end' => 'date:d.m.Y',
        'status' => Status::class
    ];

    /**
     * @param array $data
     * @param Apartment $apartment
     * @return Model
     */
    public static function createFromArray(array $data, Apartment $apartment): Model
    {
        $start = Carbon::parse(Arr::get($data, 'start'))->startOfDay();
        $end = Carbon::parse(Arr::get($data, 'end'))->subDay()->startOfDay();
        $price = $apartment->getPriceForRange($start, $end);
        return self::query()->firstOrCreate([
            'start' => $start,
            'end' => Carbon::parse(Arr::get($data, 'end'))->startOfDay(),
            'apartment_id' => Arr::get($data, 'apartment_id'),
            'user_id' => Arr::get($data, 'user_id'),
            'guests' => Arr::get($data, 'guests'),
            'children' => Arr::get($data, 'children'),
            'total_guests' => Arr::get($data, 'total_guests'),
            'range' => Arr::get($data, 'range'),
            'price' => $price,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reject(string $status_text = null): bool
    {
        $this->status_text = $status_text;
        $this->status = Status::Rejected;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function submit(Reservation $reservation): bool
    {
        $this->status = Status::Submitted;
        $this->reservation_id = $reservation->id;
        return $this->save();
    }

    public function reservation(): HasOne
    {
        return $this->hasOne(Reservation::class);
    }
}
