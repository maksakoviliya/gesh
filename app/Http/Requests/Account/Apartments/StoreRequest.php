<?php

declare(strict_types=1);

namespace App\Http\Requests\Account\Apartments;

use App\Enums\Apartments\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->apartment);
    }

    protected function prepareForValidation()
    {
        //        dd($this->all());
    }

    public function rules(): array
    {
        return [
            'step' => 'required',

            // Step 1:
            'category' => 'sometimes|required|exists:categories,id',

            // Step 2:
            'type' => ['sometimes', 'required', Rule::enum(Type::class)],
        ];
    }
}
