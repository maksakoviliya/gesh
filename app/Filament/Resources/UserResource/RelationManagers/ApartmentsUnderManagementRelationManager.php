<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApartmentsUnderManagementRelationManager extends RelationManager
{
    protected static string $relationship = 'apartmentsUnderManagement';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make()
                    ->multiple()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                ]),
            ])
            ->inverseRelationship('manager');
    }

    public function getTableQueryForExport(): Builder
    {
        // TODO: Implement getTableQueryForExport() method.
    }

    public function replaceMountedTableAction(string $name, ?string $record = null, array $arguments = []): void
    {
        // TODO: Implement replaceMountedTableAction() method.
    }

    public function replaceMountedTableBulkAction(string $name, ?array $selectedRecords = null): void
    {
        // TODO: Implement replaceMountedTableBulkAction() method.
    }
}
