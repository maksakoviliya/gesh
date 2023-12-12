<?php

namespace App\Filament\Resources\ApartmentResource\Pages;

use App\Filament\Resources\ApartmentResource;
use App\Models\Apartment;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListApartments extends ListRecords
{
    protected static string $resource = ApartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import')
                ->label('Импорт из Excel')
                ->icon('heroicon-o-document-arrow-up')
                ->color('success')
                ->form([
                    FileUpload::make('filename')
                        ->multiple(false)
                        ->disk('imports')
                        ->label('Файл')
                        ->required(),
                ])
                ->modalSubmitActionLabel('Импортировать')
                ->action(function (array $data): void {
                    Apartment::import($data['filename']);
                    Notification::make()
                        ->success()
                        ->title('Импорт завершен')
                        ->body('Проверьте объявления и одобрите их')
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
