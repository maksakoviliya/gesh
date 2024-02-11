<?php

namespace App\Filament\Resources;

use App\Enums\Reservation\Status;
use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Reservations';

    protected static ?string $navigationLabel = 'Бронирования';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->readOnly(),
                Select::make('status')
                    ->options([
                        Status::Paid->value => __('statuses.reservation.'.Status::Paid->value),
                        Status::PaymentWaiting->value => __('statuses.reservation.'.Status::PaymentWaiting->value),
                        Status::Pending->value => __('statuses.reservation.'.Status::Pending->value),
                    ]),
                Select::make('user')
                    ->searchable()
                    ->preload()
                    ->relationship('user', 'name'),
                Select::make('apartment')
                    ->searchable()
                    ->preload()
                    ->relationship('apartment', 'id'),
                TextInput::make('reservation_request_id'),
                TextInput::make('start'),
                TextInput::make('end'),
                TextInput::make('guests'),
                TextInput::make('children'),
                TextInput::make('total_guests'),
                TextInput::make('range'),
                TextInput::make('price'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->hidden(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn ($state) => __('statuses.reservation.'.$state->value))
                    ->sortable()
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        Status::Pending => 'gray',
                        Status::PaymentWaiting => 'warning',
                        Status::Paid => 'success',
                    }),
                SpatieMediaLibraryImageColumn::make('apartment.media')->label('Объект')
                    ->limit(1),
                Tables\Columns\TextColumn::make('apartment.category.title_single')->label('')
                    ->description(fn (Reservation $record): string => $record->apartment->id)
                    ->url(function (Reservation $record) {
                        return route('apartment', [
                            'apartment' => $record->apartment->id,
                        ]);
                    })
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('user.name')->label('Гость')
                    ->description(fn (Reservation $record): string => $record->user->phone ?? $record->user->email)
                    ->url(function (Reservation $record) {
                        return UserResource::getUrl('edit', ['record' => $record->user->id]);
                    }),
                Tables\Columns\TextColumn::make('price')->label('Цена')->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, '0', '.', ' ').'₽'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d.m.Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('voucher')
                    ->state(fn (Reservation $record) => $record->status !== Status::Paid ? null : 'Ваучер')
                    ->icon('heroicon-o-newspaper')
                    ->url(fn (Reservation $record): string => route('account.reservations.voucher', [
                        'reservation' => $record->id,
                        'as' => 'admin',
                    ]))
                    ->openUrlInNewTab(),
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
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
