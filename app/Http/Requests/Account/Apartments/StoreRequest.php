<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Apartments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::id(),
            'rooms' => 2,
            'guests' => 3,
            'address' => 'Адрес',
            'price' => 1200,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'user_id' => 'required|exists:users,id',
            'media' => 'required|array|max:2',
            'media.*' => 'image',
            'rooms' => 'required',
            'guests' => 'required',
            'address' => 'required',
            'price' => 'required',
        ];
    }
}
