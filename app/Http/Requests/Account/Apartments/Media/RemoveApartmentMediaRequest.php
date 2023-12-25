<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Apartments\Media;

use Illuminate\Foundation\Http\FormRequest;

final class RemoveApartmentMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('remove_media', $this->apartment);
    }

    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }
}
