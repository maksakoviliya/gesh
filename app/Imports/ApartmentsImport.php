<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use App\Models\Apartment;
use App\Models\Category;
use App\Models\User;
use Arr;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

final class ApartmentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (($name = Arr::get($row, 'vladelec')) && ((($email = Arr::get($row, 'vladelec_email')) || (($phone = Arr::get($row, 'vladelec_telefon')))))
        ) {
            $user = User::query()->firstOrCreate([
                'email' => $email,
            ], [
                'name' => $name,
                'phone' => $phone ?? null,
            ]);
        }
        $category = Category::query()->where('title', 'like', '%'.Arr::get($row, 'kategoriia').'%')->first();
        if (! $category) {
            $category = Category::query()->where('slug', 'rooms')->first();
        }
        $apartment = Apartment::query()->updateOrCreate([
            'lon' => Arr::get($row, 'koordinaty_lon'),
            'lat' => Arr::get($row, 'koordinaty_lat'),
        ], [
            'status' => Status::Draft,
            'step' => 12,
            'user_id' => $user?->id,
            'category_id' => $category->id,
            'type' => Type::tryFrom(Arr::get($row, 'tip')),
            'country_code' => 'ru',
            'state' => null,
            'city' => Arr::get($row, 'gorod'),
            'street' => Arr::get($row, 'ulica'),
            'building' => Arr::get($row, 'dom'),
            'housing' => Arr::get($row, 'korrpus'),
            'room' => Arr::get($row, 'kvartira'),
            'floor' => Arr::get($row, 'etaz'),
            'entrance' => Arr::get($row, 'podieezd'),
            'index' => Arr::get($row, 'indeks'),
            'guests' => Arr::get($row, 'gosti'),
            'bedrooms' => Arr::get($row, 'spalni'),
            'beds' => Arr::get($row, 'krovati'),
            'bathrooms' => Arr::get($row, 'vannye'),
            'title' => Arr::get($row, 'nazvanie'),
            'description' => Arr::get($row, 'opisanie'),
            'weekdays_price' => Arr::get($row, 'cena_v_budni_rub'),
            'weekends_price' => Arr::get($row, 'cena_v_vyxodnye_rub'),
            'fast_reserve' => Arr::get($row, 'mgnovennoe_bronirovanie') === 'Да',
        ]);

        if (! $apartment) {
            throw new Exception('Cannot create new apartment');
        }

        $photos = Arr::get($row, 'fotografii');
        if ($photos) {
            $photos = explode(',', $photos);
            foreach ($photos as $url) {
                try {
                    $apartment->addMediaFromUrl($url)->toMediaCollection();
                } catch (Throwable $exception) {
                    //
                }
            }
        }
    }
}
