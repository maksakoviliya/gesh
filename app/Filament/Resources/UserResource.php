<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\ApartmentsUnderManagementRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основное')
                    ->description('Основные настройки профиля пользователя')
                    ->schema([
                        TextInput::make('name')
                            ->label('Имя')
                            ->required()->columnSpan('full'),
                        TextInput::make('email')->unique(ignoreRecord: true)->nullable(),
                        TextInput::make('phone')
                            ->unique(ignoreRecord: true)
                            ->label('Телефон')
                            ->rules('phone:ru')
                            ->nullable(),
                        TextInput::make('password')
                            ->password()
                            ->label('Новый пароль')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        TextInput::make('telegram_chat_id'),
                        TextInput::make('telegram_username'),
                        Forms\Components\Select::make('roles')->multiple()
                            ->relationship('roles', 'name')->preload(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->description(fn (User $record): string => $record->roles->pluck('name')->join(', '))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('roles')
                    ->badge()
                    ->state(function (User $record) {
                        return $record->roles()->first()?->name;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('telegram_chat_id')
                    ->badge()
                    ->color(Color::Blue)
                    ->sortable()
                    ->label('Телеграм бот')
                    ->state(fn (User $record) => $record->telegram_chat_id ? 'Подключен' : null)
                    ->icon('heroicon-o-check-circle'),
                Tables\Columns\TextColumn::make('telegram_username')
                    ->label('Телеграм')
                    ->sortable()
                    ->state(fn (User $record) => $record->telegram_username ? "@$record->telegram_username" : null),
                Tables\Columns\TextColumn::make('avito_access_token')
                    ->badge()
                    ->color(Color::Blue)
                    ->sortable()
                    ->label('Авито')
                    ->state(fn (User $record) => $record->avito_access_token ? 'Подключен' : null)
                    ->icon('heroicon-o-check-circle'),
                Tables\Columns\TextColumn::make('created_at')->date('d.m.Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ApartmentsUnderManagementRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
