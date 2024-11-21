<?php

namespace App\Filament\Resources;

use App\Enums\Transfer\RegularDriveStatus;
use App\Filament\Resources\RegularDriveResource\Pages;
use App\Models\Transfer\RegularDrive;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegularDriveResource extends Resource
{
    protected static ?string $model = RegularDrive::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Трансфер';

    protected static ?string $navigationLabel = 'Регулярные поездки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('name')->columnSpan('full'),
                    Textarea::make('description')->columnSpan('full'),
                    TimePicker::make('start_at')->seconds(false),
                    TextInput::make('duration')->numeric()->hint('В минутах'),
                    TextInput::make('passengers_limit')->numeric(),
                    TextInput::make('regular_price')->numeric()->hint('Обычная цена'),

                    TextInput::make('start_point')->columnSpan('full'),
                    TextInput::make('start_lon'),
                    TextInput::make('start_lat'),
                    TextInput::make('finish_point')->columnSpan('full'),
                    TextInput::make('finish_lon'),
                    TextInput::make('finish_lat'),
                ])->columns()->columnSpan([
                    'lg' => '2',
                ]),
                Section::make([
                    Select::make('status')->options([
                        RegularDriveStatus::ACTIVE->value => RegularDriveStatus::ACTIVE->value,
                        RegularDriveStatus::DRAFT->value => RegularDriveStatus::DRAFT->value,
                    ]),
                    SpatieMediaLibraryFileUpload::make('image')->collection('banner'),
                ])->columnSpan([
                    'lg' => '1',
                ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('start_point'),
                TextColumn::make('finish_point'),
                TextColumn::make('start_at')->date('H:i'),

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
            'index' => Pages\ListRegularDrives::route('/'),
            'create' => Pages\CreateRegularDrive::route('/create'),
            'edit' => Pages\EditRegularDrive::route('/{record}/edit'),
        ];
    }
}
