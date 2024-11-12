<?php

namespace App\Filament\Resources\RegularDriveResource\Pages;

use App\Filament\Resources\RegularDriveResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegularDrives extends ListRecords
{
    protected static string $resource = RegularDriveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
