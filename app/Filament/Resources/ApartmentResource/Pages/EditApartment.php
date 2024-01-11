<?php

declare(strict_types=1);

namespace App\Filament\Resources\ApartmentResource\Pages;

use App\Enums\Apartments\Status;
use App\Filament\Resources\ApartmentResource;
use App\Filament\Resources\ApartmentResource\Widgets\CalendarWidget;
use App\Models\Apartment;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditApartment extends EditRecord
{
    protected static string $resource = ApartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->color('success')
                ->label('Одобрить')
                ->disabled(fn (Apartment $record) => $record->status === Status::Published)
                ->action(function (Apartment $record) {
                    $record->approve();
                    Notification::make()
                        ->success()
                        ->title('Жилье одобрено')
                        ->body('Теперь это объявление доступно для всех.')
                        ->send();
                })
                ->requiresConfirmation(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getFooterWidgetsColumns(): int|string|array
    {
        return 1;
    }

    protected function getFooterWidgets(): array
    {
        return [
            //            CalendarWidget::class,
        ];
    }
}
