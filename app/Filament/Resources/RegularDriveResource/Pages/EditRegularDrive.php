<?php

namespace App\Filament\Resources\RegularDriveResource\Pages;

use App\Filament\Resources\RegularDriveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegularDrive extends EditRecord
{
    protected static string $resource = RegularDriveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
