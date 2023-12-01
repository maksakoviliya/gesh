<?php

declare(strict_types=1);

namespace App\Http\Requests\Chat\Messages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
            'chat_id' => $this->chat?->id,
            'apartment_id' => $this->chat?->apartment?->id
        ]);
    }

    public function rules(): array
    {
        return [
            'chat_id' => 'required|exists:chats,id',
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|min:1|max:9999'
        ];
    }
}
