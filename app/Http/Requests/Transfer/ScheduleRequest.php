<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\PhoneNumber;

class ScheduleRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $phone = new PhoneNumber($this->input('phone'), 'RU');
        if ($phone->isValid()) {
            $this->merge([
                'phone' => $phone,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required|phone:RU',
        ];
    }
}
