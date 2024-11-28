<?php

declare(strict_types=1);

namespace App\Http\Requests\Transfer\RegularRide;

use App\Services\Transfer\RegularDriveService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

final class BookRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'start_at' => Carbon::parse($this->input('start_at')),
        ]);
    }

    public function rules(): array
    {
        $regularDriveService = new RegularDriveService;
        $max = $regularDriveService->getAvailableSeatsForDay($this->drive, $this->start_at);

        return [
            'start_at' => 'required|date',
            'seats_count' => [
                'required', 'integer', 'min:1', 'max:'.$max,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'seats_count.max' => 'Нет столько свободных мест.',
        ];
    }
}
