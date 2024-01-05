<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SideReservationResource\Pages;
use App\Models\SideReservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SideReservationResource extends Resource
{
    protected static ?string $model = SideReservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Reservations';

    protected static ?string $navigationLabel = 'Сторонние бронирования';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id'),
                Forms\Components\Select::make('apartment')
                    ->relationship('apartment', 'id'),
                Forms\Components\DateTimePicker::make('start'),
                Forms\Components\DateTimePicker::make('end'),
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('summary'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable(),
                Tables\Columns\TextColumn::make('apartment.id')
                    ->searchable()
                    ->url(function (SideReservation $record) {
                        if (! $record->apartment) {
                            return '#';
                        }

                        return ApartmentResource::getUrl('edit', ['record' => $record->apartment->id]);
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d.m.Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSideReservations::route('/'),
            'create' => Pages\CreateSideReservation::route('/create'),
            'edit' => Pages\EditSideReservation::route('/{record}/edit'),
        ];
    }
}
