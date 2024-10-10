<?php

namespace App\Filament\Resources\ApartmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SideReservationsRelationManager extends RelationManager
{
    protected static string $relationship = 'sideReservations';

    protected static ?string $title = 'Синхронизировано со сторонними ресурсами';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('summary')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('summary')
            ->columns([
                Tables\Columns\TextColumn::make('start')->date('d.m.Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('end')->date('d.m.Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('summary')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date('d.m.Y H:i')->sortable(),
            ])
            ->defaultSort('start')
            ->filters([
                Filter::make('only_new')
                    ->label('Только предстоящие')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('start', '>', now()->startOfDay()))
                    ->default(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
