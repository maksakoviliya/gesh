<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Apartments;

use Illuminate\Foundation\Http\FormRequest;

final class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('delete', $this->apartment);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
