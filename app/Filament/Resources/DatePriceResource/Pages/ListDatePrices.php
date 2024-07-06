<?php

namespace App\Filament\Resources\DatePriceResource\Pages;

use App\Filament\Resources\DatePriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDatePrices extends ListRecords
{
    protected static string $resource = DatePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
