<?php

declare(strict_types=1);

namespace App\Http\Requests\Instructors;

use Illuminate\Foundation\Http\FormRequest;

final class ScheduleRequest extends FormRequest
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
