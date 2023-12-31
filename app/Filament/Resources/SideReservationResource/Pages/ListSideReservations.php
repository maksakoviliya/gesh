<?php

namespace App\Filament\Resources\SideReservationResource\Pages;

use App\Filament\Resources\SideReservationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSideReservations extends ListRecords
{
    protected static string $resource = SideReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
