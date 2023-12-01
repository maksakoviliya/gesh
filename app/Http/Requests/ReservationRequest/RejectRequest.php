<?php

declare(strict_types=1);

namespace App\Http\Requests\ReservationRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class RejectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'status_text' => 'nullable|string|max:255',
        ];
    }
}
