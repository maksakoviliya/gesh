<?php

namespace App\Filament\Resources;

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
                Forms\Components\Section::make()
                    ->schema([
                        Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->preload()
                            ->required()
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('title')
                            ->columnSpan('full'),
                        Forms\Components\Textarea::make('address')
                            ->columnSpan('full')
                            ->required(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->disableToolbarButtons([
                                'table',
                                'attachFiles',
                            ])
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('bedrooms')
                            ->numeric()
                            ->maxValue(10)
                            ->default(1)
                            ->required(),
                        Forms\Components\TextInput::make('guests')
                            ->numeric()
                            ->maxValue(30)
                            ->default(2)
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Images')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('media')
                            ->multiple()
                            ->maxFiles(10)
                            ->required(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')
                    ->limit(1),
                Tables\Columns\TextColumn::make('categories.title')
                    ->badge(),
                Tables\Columns\TextColumn::make('price'),
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
