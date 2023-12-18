<?php

declare(strict_types=1);

namespace App\Http\Requests\ReservationRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'apartment_id' => $this->apartment?->id,
            'total_guests' => $this->input('guests', 0) + $this->input('children', 0),
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'apartment_id' => 'required|exists:apartments,id',
            'user_id' => 'required|exists:users,id',
            'start' => 'required|date',
            'end' => 'required|date',
            'range' => 'required',
            'guests' => 'required',
            'children' => 'required',
            'total_guests' => [
                'required',
                'integer',
                'min:1',
                "max:{$this->apartment->guests}",
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'total_guests.max' => 'Максимальное число гостей: :max.'
        ];
    }
}
