<?php

declare(strict_types=1);

namespace App\Filament\Resources\ApartmentResource\Pages;

use App\Enums\Apartments\Status;
use App\Filament\Resources\ApartmentResource;
use Arr;
use Filament\Resources\Pages\CreateRecord;

final class CreateApartment extends CreateRecord
{
    protected static string $resource = ApartmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Arr::set($data, 'status', Status::Draft);

        return $data;
    }
}
