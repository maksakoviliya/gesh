<?php

namespace App\Filament\Resources;

use App\Enums\Apartments\Status;
use App\Enums\Apartments\Type;
use App\Filament\Resources\ApartmentResource\Pages;
use App\Models\Apartment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class ApartmentResource extends Resource
{
    protected static ?string $model = Apartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Шаг 1')
                                    ->schema([
                                        Select::make('categories')
                                            ->relationship('categories', 'title')
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
                                        Forms\Components\TextInput::make('index'),
                                    ])->collapsible(),


                            ])->columnSpan(['lg' => fn (?Apartment $record) => $record === null ? 3 : 2]),
                       Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Добавлен')
                                    ->content(fn (Apartment $record): ?string => $record->created_at?->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Изменен')
                                    ->content(fn (Apartment $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->columnSpan(['lg' => 1])
                            ->hidden(fn (?Apartment $record) => $record === null),

                        Forms\Components\Section::make('Images')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('media')
                                    ->multiple()
                                    ->maxFiles(10)
                                    ->required(),
                            ])
                            ->collapsible(),
                    ])
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
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function (Status $state) {
                        return match ($state) {
                            Status::Draft => 'gray',
                            Status::Pending => 'primary'
                        };
                    }),
                Tables\Columns\TextColumn::make('weekdays_price'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('bedrooms'),
                Tables\Columns\TextColumn::make('guests'),
            ])
            ->filters([
                //
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
