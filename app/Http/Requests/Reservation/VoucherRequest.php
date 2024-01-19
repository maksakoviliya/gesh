<?php

declare(strict_types=1);

namespace App\Http\Requests\Reservation;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

final class VoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::id() === $this->reservation?->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
