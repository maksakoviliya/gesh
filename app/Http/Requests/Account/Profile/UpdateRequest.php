<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Profile;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|max:155',
            'email' => 'sometimes|required|email|unique:users,email|max:155',
            'phone' => 'sometimes|required|phone:RU|unique:users,phone|max:155',
        ];
    }
}
