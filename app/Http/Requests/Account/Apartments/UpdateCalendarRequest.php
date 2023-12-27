<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Apartments;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->apartment);
    }

    public function rules(): array
    {
        return [
            'start' => 'required|date',
            'end' => 'required|date',
            'price' => 'nullable|integer|min:2|max:9999999',
            'disabled' => 'nullable|boolean',
        ];
    }
}
