<?php

namespace App\Filament\Resources;

use App\Enums\ReservationRequest\Status;
use App\Filament\Resources\ReservationRequestResource\Pages;
use App\Models\ReservationRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class ReservationRequestResource extends Resource
{
    protected static ?string $model = ReservationRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Reservations';

    protected static ?string $navigationLabel = 'Запросы на бронирование';

    public static function getNavigationBadge(): ?string
    {
        return ReservationRequest::query()->where('status', Status::Pending)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return Color::Red;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('apartment')
                    ->searchable()
                    ->relationship('apartment', 'id'),
                Forms\Components\Select::make('user')
                    ->relationship('user', 'id'),
                Forms\Components\DatePicker::make('start'),
                Forms\Components\DatePicker::make('end'),
                Forms\Components\TextInput::make('guests'),
                Forms\Components\TextInput::make('children'),
                Forms\Components\TextInput::make('total_guests'),
                Forms\Components\TextInput::make('price'),
                Forms\Components\Select::make('status')->options([
                    Status::Pending->value => __('statuses.reservation_request.pending'),
                    Status::Rejected->value => __('statuses.reservation_request.rejected'),
                    Status::Submitted->value => __('statuses.reservation_request.submitted'),
                ])->required(),
                Forms\Components\TextInput::make('status_text'),
                Forms\Components\Select::make('reservation')
                    ->relationship('reservation', 'id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('apartment.media')->label('Объект')
                    ->limit(1),
                Tables\Columns\TextColumn::make('apartment.category.title')->label('')
                    ->description(fn (ReservationRequest $record): string => $record->apartment->id)
                    ->url(function (ReservationRequest $record) {
                        return ApartmentResource::getUrl('edit', ['record' => $record->apartment->id]);
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn ($state) => __('statuses.reservation_request.'.$state->value))
                    ->sortable()
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        Status::Rejected => 'danger',
                        Status::Submitted => 'success',
                        Status::Pending => 'gray',
                    }),
                Tables\Columns\TextColumn::make('apartment.user.name')->label('Владелец')
                    ->description(fn (ReservationRequest $record): string => $record->apartment->user?->email ?? $record->apartment->user?->phone ?? '-')
                    ->url(function ($record) {
                        if (! $record->apartment->user) {
                            return '#';
                        }

                        return UserResource::getUrl('edit', ['record' => $record->apartment->user->id]);
                    }),
                Tables\Columns\TextColumn::make('user.name')->label('Гость')
                    ->description(fn (ReservationRequest $record): string => $record->user?->email ?? $record->user?->phone)
                    ->url(function ($record) {
                        if (! $record->user) {
                            return '#';
                        }

                        return UserResource::getUrl('edit', ['record' => $record->user->id]);
                    }),
                Tables\Columns\TextColumn::make('start')->label('Заезд')->date('d.m.Y')->sortable(),
                Tables\Columns\TextColumn::make('end')->label('Выезд')->date('d.m.Y')->sortable(),
                Tables\Columns\TextColumn::make('guests')->label('Гости')->icon('heroicon-o-user')->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Цена')->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, '0', '.', ' ').'₽'),
                Tables\Columns\TextColumn::make('created_at')->label('Создан')->date('d.m.Y H:i')->sortable(),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('apartment')
                    ->relationship('apartment', 'id')
                    ->searchable()
                    ->preload()
                    ->label('Объект'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        Status::Pending->value => 'Ожидает',
                        Status::Submitted->value => 'Одобрен',
                        Status::Rejected->value => 'Отказано',
                    ])
                    ->label('По статусу'),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->has('apartment');
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
            'index' => Pages\ListReservationRequests::route('/'),
            'create' => Pages\CreateReservationRequest::route('/create'),
            'edit' => Pages\EditReservationRequest::route('/{record}/edit'),
        ];
    }
}
