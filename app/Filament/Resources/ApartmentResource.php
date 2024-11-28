<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use App\Filament\Resources\ApartmentResource\Pages;
use App\Filament\Resources\ApartmentResource\RelationManagers\DatePricesRelationManager;
use App\Filament\Resources\ApartmentResource\RelationManagers\DisabledDatesRelationManager;
use App\Filament\Resources\ApartmentResource\RelationManagers\SideReservationsRelationManager;
use App\Models\Apartment;
use App\Models\User;
use Auth;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ApartmentResource extends Resource
{
    protected static ?string $model = Apartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Apartments';

    protected static ?string $navigationLabel = 'Объекты';

    public static function getNavigationBadge(): ?string
    {
        return strval(Apartment::query()->where('status', Status::Pending)->count()) ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return Color::Red;
    }

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
                                    ->disabled(! Auth::user()->hasRole(['admin']))
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
                                    ->disabled(! Auth::user()->hasRole(['admin']))
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
                            ])->collapsible()->disabled(! Auth::user()->hasRole(['admin']))->columns()->collapsed(),
                        Forms\Components\Section::make('Шаг 4')
                            ->schema([
                                //                                        Map::make('location')->label('Гугл карта не рабоатет. Нужен ключ.')->columnSpan('full'),
                                Forms\Components\TextInput::make('lat'),
                                Forms\Components\TextInput::make('lon'),
                            ])->disabled(! Auth::user()->hasRole(['admin']))->collapsible()->collapsed()->columns(),
                        Forms\Components\Section::make('Шаг 5')
                            ->schema([
                                Forms\Components\TextInput::make('guests'),
                                Forms\Components\TextInput::make('bedrooms'),
                                Forms\Components\TextInput::make('beds'),
                                Forms\Components\TextInput::make('bathrooms'),
                            ])->disabled(! Auth::user()->hasRole(['admin']))->collapsible()->columns(4),
                        Forms\Components\Section::make('Шаг 6')
                            ->schema([
                                Select::make('features')
                                    ->relationship('features', 'title')
                                    ->multiple()
                                    ->preload()
                                    ->columnSpan('full'),
                            ])->disabled(! Auth::user()->hasRole(['admin']))->collapsible(),
                        Forms\Components\Section::make('Шаг 7')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->multiple()
                                    ->reorderable()
                                    ->imageEditor()
                                    ->imageEditorMode(2)
                                    ->appendFiles(),
                            ])
                            ->disabled(! Auth::user()->hasRole(['admin']))
                            ->collapsible()->collapsed(),
                        Forms\Components\Section::make('Шаг 8')
                            ->schema([
                                Forms\Components\TextInput::make('title'),
                            ])->disabled(! Auth::user()->hasRole(['admin']))->collapsible(),
                        Forms\Components\Section::make('Шаг 9')
                            ->schema([
                                Forms\Components\Textarea::make('description'),
                            ])->disabled(! Auth::user()->hasRole(['admin']))->collapsible(),
                        Forms\Components\Section::make('Шаг 10')
                            ->schema([
                                Forms\Components\TextInput::make('weekdays_price')->label('Цена в будни'),
                                Forms\Components\TextInput::make('weekends_price')->label('Цена в выходные'),
                            ])->disabled(! Auth::user()->hasRole(['admin']))->collapsible()->columns(),
                        Forms\Components\Section::make('Шаг 11')
                            ->schema([
                                Forms\Components\Toggle::make('fast_reserve')->label('Моментальное бронирование'),
                            ])->disabled(! Auth::user()->hasRole(['admin']))->collapsible()->columns(),

                    ])->columnSpan(['lg' => fn (?Apartment $record) => $record === null ? 3 : 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        Status::Draft->value => 'Черновик',
                                        Status::Pending->value => 'На модерации',
                                        Status::Published->value => 'Опубликован',
                                    ])->required()
                                    ->disabled(! Auth::user()->hasRole(['admin', 'moderator']))
                                    ->nullable(false),
                                Forms\Components\Toggle::make('is_verified')->label('Подтвержден')->disabled(! Auth::user()->hasRole(['admin', 'moderator'])),
                                Select::make('user')->relationship('user', 'name')
                                    ->searchable()
                                    ->disabled(! Auth::user()->hasRole(['admin']))
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

                        // Hidden for now
                        Forms\Components\Section::make('Авито')
                            ->disabled(! config('services.avito.enabled'))
                            ->hidden(! config('services.avito.enabled'))
                            ->schema([
                                TextInput::make('avito_id')
                                    ->label('ID объявления')
                                    ->nullable(),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('Сслки ICAL')
                            ->schema([
                                Repeater::make('ICalLinks')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('link')->required()->unique(ignoreRecord: true),
                                    ]),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('Avito')
                            ->schema([
                                TextInput::make('avito_id')->nullable()
                                    ->suffixAction(fn (?string $state): Action => Action::make('visit')
                                        ->icon('heroicon-o-link')
                                        ->url(
                                            filled($state) ? "https://avito.ru/$state" : null,
                                            shouldOpenInNewTab: true,
                                        ),
                                    ),
                                TextInput::make('avito_link')->nullable()
                                    ->suffixAction(fn (?string $state): Action => Action::make('visit')
                                        ->icon('heroicon-o-link')
                                        ->url(
                                            $state ?? null,
                                            shouldOpenInNewTab: true,
                                        ),
                                    ),
                            ])
                            ->collapsible(),
                    ]),
            ])
            ->columns(3);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->label('Объект')
                    ->square()
                    ->limit(1),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->icon('heroicon-o-check-badge')
                    ->falseColor('gray')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category.title_single')
                    ->label('Название')
                    ->color('primary')
                    ->url(fn (Apartment $record) => route('apartment', $record->id), true)
                    ->description(fn (Apartment $record): string => "$record->city, $record->street, $record->building")
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Владелец')
                    ->description(fn (Apartment $record): string => $record->user?->email ?? '')
                    ->url(function ($record) {
                        if (! Auth::user()->hasRole(['admin'])) {
                            return false;
                        }

                        if (! $record->user) {
                            return false;
                        }

                        return UserResource::getUrl('edit', ['record' => $record->user]);
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (Status $state): string => __("statuses.{$state->value}"))
                    ->color(function (Status $state) {
                        return match ($state) {
                            Status::Draft => 'gray',
                            Status::Pending => 'primary',
                            Status::Published => 'success'
                        };
                    })
                    ->toggleable(),
                TextColumn::make('avito_id')
                    ->label('ID на авито')
                    ->sortable(),
                TextColumn::make('i_cal_links_count')
                    ->badge()
                    ->label('Сторонние календари')
                    ->state(function (Apartment $record) {
                        return $record->ICalLinks()->count() > 0 ? 'Синхронизированы' : null;
                    })
                    ->color(Color::Blue)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('weekdays_price')->sortable()->money('RUB')->toggleable(),
                Tables\Columns\TextColumn::make('weekends_price')->sortable()->money('RUB')->toggleable(),
                Tables\Columns\TextColumn::make('title')->searchable()
                    ->url(fn (Apartment $record) => route('apartment', $record->id), true)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('bedrooms')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('guests')
                    ->toggleable(),
                TextColumn::make('created_at')->date('d.m.Y H:i')->sortable()->toggleable(),
                TextColumn::make('updated_at')->date('d.m.Y H:i')->sortable()->toggleable(),
                TextColumn::make('id')
                    ->color('primary')
                    ->url(fn (Apartment $record) => route('apartment', $record->id), true)
                    ->searchable()->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        Status::Draft->value => 'Черновики',
                        Status::Pending->value => 'На модерации',
                        Status::Published->value => 'Активные',
                    ])->label('По статусу'),
                Tables\Filters\SelectFilter::make('manager_id')
                    ->visible(Auth::user()->hasRole('admin'))
                    ->options(function () {
                        // Получаем пользователей с ролью 'manager'
                        return User::role('manager')->pluck('name', 'id');
                    }),
                Filter::make('under_management')
                    ->visible(Auth::user()->hasRole('manager'))
                    ->query(fn (Builder $query): Builder => $query->where('manager_id', Auth::id()))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Одобрить')
                    ->visible(fn (Apartment $record) => $record->status === Status::Pending)
                    ->icon('heroicon-o-check-circle')
                    ->action(function (Apartment $record) {
                        $record->approve();
                        Notification::make()
                            ->success()
                            ->title('Одобрено!')
                            ->color('success')
                            ->body('Объект одобрен и опубликован')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export')
                        ->label('Экспортировать в .xlsx')
                        ->icon('heroicon-o-document-arrow-down')
                        ->authorize(auth()->user()->hasRole('admin'))
                        ->action(function (Collection $records) {
                            return Apartment::export($records);
                        }),
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Одобрить')
                        ->icon('heroicon-o-check-circle')
                        ->authorize(auth()->user()->hasRole('admin'))
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
                    Tables\Actions\DeleteBulkAction::make()->authorize(auth()->user()->hasRole('admin')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            SideReservationsRelationManager::class,
            DatePricesRelationManager::class,
            DisabledDatesRelationManager::class,
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
