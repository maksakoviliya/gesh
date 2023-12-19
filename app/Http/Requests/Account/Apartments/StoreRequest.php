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

    protected function prepareForValidation(): void
    {
        if ($this->input('step') === 3) {
            $this->merge([
                'country_code' => 'ru',
            ]);
        }
        if ($this->input('step') === 7) {
            $totalMedia = count(
                $this->input('media', [])
            )
                + count(
                    $this->input('remove', []))
                + count(
                    $this->input('current', [])
                );
            $this->merge([
                'total_media' => $totalMedia,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'step' => 'required',

            // Step 1:
            'category_id' => 'sometimes|required|exists:categories,id',

            // Step 2:
            'type' => ['sometimes', 'required', Rule::enum(Type::class)],

            // Step 3:
            'country_code' => 'sometimes|required',
            'state' => 'sometimes|nullable',
            'city' => 'sometimes|required',
            'street' => 'sometimes|required',
            'building' => 'sometimes|required',
            'housing' => 'sometimes|nullable',
            'room' => 'sometimes|nullable',
            'floor' => 'sometimes|nullable',
            'entrance' => 'sometimes|nullable',
            'index' => 'sometimes|nullable',

            // Step 4:
            'lon' => 'sometimes|required',
            'lat' => 'sometimes|required',

            // Step 5:
            'guests' => 'sometimes|required|numeric|min:1|max:20',
            'bedrooms' => 'sometimes|required|numeric|min:0|max:10',
            'beds' => 'sometimes|required|numeric|min:0|max:10',
            'bathrooms' => 'sometimes|required|numeric|min:0|max:10',

            // Step 6:
            'features' => 'sometimes|nullable|array',

            // Step 7:
            'media' => ['sometimes', 'nullable', 'array', 'max:10'],
            'total_media' => 'sometimes|required|numeric|min:1',
            'media.*' => 'sometimes|required|image|max:6000',
            'remove' => 'sometimes|nullable|array',

            // Step 8:
            'title' => 'sometimes|nullable|max:255',

            // Step 9:
            'description' => 'sometimes|nullable|max:1000',

            // Step 10:
            'weekdays_price' => 'sometimes|required|integer|max:9999999',
            'weekends_price' => 'sometimes|required|integer|max:9999999',

            // Step 11:
            'fast_reserve' => 'sometimes|required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Необходимо укзать категорию жилья.',
            'type.required' => 'Необходимо укзать тип жилья.',
            'total_media' => 'Необходимо загрузить изображение',
        ];
    }

    public function attributes(): array
    {
        return [
            'media' => 'фото',
        ];
    }
}
