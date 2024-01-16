<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Profile;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Propaganistas\LaravelPhone\PhoneNumber;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::id() === $this->input('account');
    }

    protected function prepareForValidation(): void
    {
        $phone = new PhoneNumber($this->input('phone'), 'RU');
        if ($phone->isValid()) {
            $this->merge([
                'phone' => $phone,
            ]);
        }
        $this->replace(array_filter($this->all()));
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:155',
            'email' => [
                'required',
                'email',
                'max:155',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'phone' => [
                'required',
                'phone:RU',
                'max:155',
                Rule::unique('users')->ignore($this->user()->id),
            ],

            'old_password' => 'sometimes|max:155|current_password:web',
            'password' => [
                Rule::requiredIf(fn () => $this->input('old_password')),
                new Password(6),
                'confirmed',
            ],
        ];
    }
}
