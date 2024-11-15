<?php

namespace App\Filament\Resources;

use App\Enums\Transfer\DriveUserStatus;
use App\Filament\Resources\DriveUserResource\Pages;
use App\Filament\Resources\DriveUserResource\RelationManagers;
use App\Models\Transfer\DriveUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriveUserResource extends Resource
{
    protected static ?string $model = DriveUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Трансфер';

    protected static ?string $navigationLabel = 'Бронирования поездок';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('drive_id')->required()->relationship('regularDrive', 'name'),
                Forms\Components\Select::make('user_id')->required()->relationship('user', 'phone'),
                Forms\Components\Select::make('status')->required()->options([
                    DriveUserStatus::Pending->value => DriveUserStatus::Pending->value,
                    DriveUserStatus::Paid->value => DriveUserStatus::Paid->value,
                    DriveUserStatus::Cancelled->value => DriveUserStatus::Cancelled->value
                ]),
                Forms\Components\DatePicker::make('start_at')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('drive_id')->searchable(),
                Tables\Columns\TextColumn::make('user_id')->searchable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn (DriveUserStatus $state): string => match ($state) {
                    DriveUserStatus::Pending => 'primary',
                    DriveUserStatus::Paid => 'success',
                    DriveUserStatus::Cancelled => 'danger'
                }),
                Tables\Columns\TextColumn::make('start_at')->date('d.m.Y')->sortable()
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDriveUsers::route('/'),
        ];
    }
}
