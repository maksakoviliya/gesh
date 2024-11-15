<?php

namespace App\Filament\Resources\DriveUserResource\Pages;

use App\Filament\Resources\DriveUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDriveUsers extends ManageRecords
{
    protected static string $resource = DriveUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
