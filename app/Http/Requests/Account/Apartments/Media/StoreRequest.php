<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Apartments\Media;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('add_media', $this->apartment);
    }

    public function rules(): array
    {
        return [
            'files' => 'required|array',
            'files.*' => 'required|image',
        ];
    }

    public function messages(): array
    {
        return [
            'files.required' => 'Необходимо выбрать хотя бы один файл.'
        ];
    }
}
