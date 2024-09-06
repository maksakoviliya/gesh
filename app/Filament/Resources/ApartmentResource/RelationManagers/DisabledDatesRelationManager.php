<?php

declare(strict_types=1);

namespace App\Filament\Resources\ApartmentResource\RelationManagers;

use Carbon\CarbonInterface;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class DisabledDatesRelationManager extends RelationManager
{
    protected static ?string $title = 'Недоступные даты';

    protected static string $relationship = 'disabledDates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start')
                    ->required(),
                DatePicker::make('end')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start')
            ->columns([
                TextColumn::make('start'),
                TextColumn::make('end'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
