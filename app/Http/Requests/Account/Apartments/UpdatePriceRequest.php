<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Apartments;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->apartment);
    }

    public function rules(): array
    {
        return [
            'weekdays_price' => 'required|integer|min:2|max:9999999',
            'weekends_price' => 'required|integer|min:2|max:9999999',
            'i_cal_links' => 'array|max:5',
            'i_cal_links.*.link' => 'required|url',
            'avito_id' => 'nullable',
        ];
    }
}
