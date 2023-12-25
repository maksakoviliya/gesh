<?php

namespace App\Filament\Resources;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use App\Filament\Resources\ApartmentResource\Pages;
use App\Models\Apartment;
use App\Models\User;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ApartmentResource extends Resource
{
    protected static ?string $model = Apartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Apartments';

    protected static ?string $navigationLabel = 'Объекты';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Шаг 1')
                            ->schema([
                                Select::make('category')
                                    ->relationship('category', 'title')
                                    ->preload()
                                    ->columnSpan('full'),
                            ])
                            ->columns(3),
                        Forms\Components\Section::make('Шаг 2')
                            ->schema([
                                Select::make('type')
                                    ->options([
                                        Type::WHOLE->value => 'Жилье целиком',
                                        Type::ROOM->value => 'Комната',
                                        Type::HOSTEL->value => 'Общая комната',
                                    ])
                                    ->columnSpan('full'),
                            ])
                            ->columns(3),
                        Forms\Components\Section::make('Шаг 3')
                            ->schema([
                                Forms\Components\TextInput::make('country_code')->disabled(),
                                Forms\Components\TextInput::make('state'),
                                Forms\Components\TextInput::make('city'),
                                Forms\Components\TextInput::make('street'),
                                Forms\Components\TextInput::make('building'),
                                Forms\Components\TextInput::make('housing'),
                                Forms\Components\TextInput::make('room'),
                                Forms\Components\TextInput::make('floor'),
                                Forms\Components\TextInput::make('entrance'),
                                //                                Forms\Components\TextInput::make('index'),
                            ])->collapsible()->columns()->collapsed(),
                        Forms\Components\Section::make('Шаг 4')
                            ->schema([
                                //                                        Map::make('location')->label('Гугл карта не рабоатет. Нужен ключ.')->columnSpan('full'),
                                Forms\Components\TextInput::make('lat'),
                                Forms\Components\TextInput::make('lon'),
                            ])->collapsible()->collapsed()->columns(),
                        Forms\Components\Section::make('Шаг 5')
                            ->schema([
                                Forms\Components\TextInput::make('guests'),
                                Forms\Components\TextInput::make('bedrooms'),
                                Forms\Components\TextInput::make('beds'),
                                Forms\Components\TextInput::make('bathrooms'),
                            ])->collapsible()->columns(4),
                        Forms\Components\Section::make('Шаг 6')
                            ->schema([
                                Select::make('features')
                                    ->relationship('features', 'title')
                                    ->multiple()
                                    ->preload()
                                    ->columnSpan('full'),
                            ])->collapsible(),
                        Forms\Components\Section::make('Шаг 8')
                            ->schema([
                                Forms\Components\TextInput::make('title'),
                            ])->collapsible(),
                        Forms\Components\Section::make('Шаг 9')
                            ->schema([
                                Forms\Components\Textarea::make('description'),
                            ])->collapsible(),
                        Forms\Components\Section::make('Шаг 10')
                            ->schema([
                                Forms\Components\TextInput::make('weekdays_price')->label('Цена в будни'),
                                Forms\Components\TextInput::make('weekends_price')->label('Цена в выходные'),
                            ])->collapsible()->columns(),
                        Forms\Components\Section::make('Шаг 11')
                            ->schema([
                                Forms\Components\Toggle::make('fast_reserve')->label('Моментальное бронирование'),
                            ])->collapsible()->columns(),

                    ])->columnSpan(['lg' => fn (?Apartment $record) => $record === null ? 3 : 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('status')
                                    ->label('Статус')
                                    ->content(fn (Apartment $record) => __('statuses.'.$record->status->value)),
                                Select::make('user')->relationship('user', 'name')
                                    ->searchable()
                                    ->getOptionLabelFromRecordUsing(fn (User $record) => "{$record->name} | {$record->email}")
                                    ->preload(),
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Добавлен')
                                    ->content(fn (Apartment $record): ?string => $record->created_at?->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Изменен')
                                    ->content(fn (Apartment $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Apartment $record) => $record === null),

                        Forms\Components\Section::make('Шаг 7')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->multiple()
                                    ->reorderable()
                                    ->maxFiles(10),
                            ])
                            ->collapsible(),
                    ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->limit(1),
                Tables\Columns\TextColumn::make('categories.title')
                    ->badge(),
                TextColumn::make('user.name')
                    ->description(fn (Apartment $record): string => $record->user?->email ?? '')
                    ->url(function ($record) {
                        if (! $record->user) {
                            return null;
                        }

                        return UserResource::getUrl('edit', ['record' => $record->user]);
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (Status $state): string => __("statuses.{$state->value}"))
                    ->color(function (Status $state) {
                        return match ($state) {
                            Status::Draft => 'gray',
                            Status::Pending => 'primary',
                            Status::Published => 'success'
                        };
                    }),
                Tables\Columns\TextColumn::make('weekdays_price'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('bedrooms'),
                Tables\Columns\TextColumn::make('guests'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export')
                        ->label('Экспортировать в .xlsx')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records) {
                            return Apartment::export($records);
                        }),
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Одобрить')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records) {
                            foreach ($records as $apartment) {
                                $apartment->approve();
                            }
                            Notification::make()
                                ->success()
                                ->title('Одобрено!')
                                ->color('success')
                                ->body('Выбранные объекты одобрены и опубликованы')
                                ->send();
                        }),
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
            'index' => Pages\ListApartments::route('/'),
            'create' => Pages\CreateApartment::route('/create'),
            'edit' => Pages\EditApartment::route('/{record}/edit'),
        ];
    }
}
