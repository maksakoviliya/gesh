<?php

declare(strict_types=1);

namespace App\Http\Requests\ContactRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;

final class StoreContactRequestRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->preparePhoneNumber();
        $this->prepareTelegramUsername();
        $this->filterEmptyValues();
    }

    private function preparePhoneNumber(): void
    {
        $phone = new PhoneNumber($this->input('phone'), 'RU');
        if ($phone->isValid()) {
            $this->merge(['phone' => $phone]);
        }
    }

    private function prepareTelegramUsername(): void
    {
        $telegramUsername = $this->input('telegram_username');
        if ($telegramUsername) {
            $this->merge([
                'telegram_username' => ltrim($telegramUsername, '@'),
            ]);
        }
    }

    private function filterEmptyValues(): void
    {
        $this->replace(array_filter($this->all()));
    }

    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'apartment_id' => 'required|exists:apartments,id',
            'name' => 'required|string|max:255',
            'phone' => [
                'nullable',
                'required',
                'phone:RU',
                'max:155',
                Rule::unique('users')->ignore($this->user()?->id),
            ],
            'telegram_username' => [
                'nullable',
                'string',
                'min:5',
                'max:32',
                'regex:/^[a-zA-Z0-9_]+$/',
            ],
        ];
    }
}
