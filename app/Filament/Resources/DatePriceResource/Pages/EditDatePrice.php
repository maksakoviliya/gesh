<?php

namespace App\Filament\Resources\DatePriceResource\Pages;

use App\Filament\Resources\DatePriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDatePrice extends EditRecord
{
    protected static string $resource = DatePriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
