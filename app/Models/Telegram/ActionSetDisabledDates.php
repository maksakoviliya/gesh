<?php

namespace App\Models\Telegram;

use App\Models\DisabledDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Throwable;

class ActionSetDisabledDates extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
    ];

    public function processDatesText(string $text): bool
    {
        try {
            $range = explode('-', $text);

            $start = Carbon::createFromFormat('d.m.Y', trim($range[0]));
            $end = Carbon::createFromFormat('d.m.Y', trim($range[1]));

            if (! $start || ! $end) {
                return false;
            }

            DisabledDate::query()
                ->updateOrCreate([
                    'apartment_id' => $this->apartment_id,
                    'start' => $start
                        ->setTime(15, 0),
                    'end' => $end
                        ->setTime(12, 0),
                ]);

            return $this->delete();
        } catch (Throwable $e) {
            return false;
        }
    }
}
