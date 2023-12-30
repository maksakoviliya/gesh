<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required|string|phone:RU',
        ];
    }
}
