<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Arr;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Propaganistas\LaravelPhone\PhoneNumber;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function prepareForValidation($attributes): array
    {
        $phone = new PhoneNumber(Arr::get($attributes, 'data.phone'), 'RU');
        if ($phone->isValid()) {
            Arr::set($attributes, 'data.phone', $phone->formatE164());
        }

        return $attributes;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $phone = new PhoneNumber(Arr::get($data, 'phone'), 'RU');
        if ($phone->isValid()) {
            Arr::set($data, 'phone', $phone->formatE164());
        }

        return $data;
    }
}
