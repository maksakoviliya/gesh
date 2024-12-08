<?php

namespace App\Filament\Resources\ApartmentResource\RelationManagers;

use App\Enums\ReservationRequest\Status;
use App\Models\ReservationRequest;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'reservationRequests';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->required()->numeric(),
                Forms\Components\TextInput::make('first_payment')
                    ->required()->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->description(fn (ReservationRequest $record): string => $record->user?->phone)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn (Status $state): string => match ($state) {
                    Status::Pending => 'primary',
                    Status::Rejected => 'danger',
                    Status::Submitted => 'success',
                }),
                Tables\Columns\TextColumn::make('start')->date('d.m.y')->sortable(),
                Tables\Columns\TextColumn::make('end')->date('d.m.y')->sortable(),
                Tables\Columns\TextColumn::make('price')->sortable(),
                Tables\Columns\TextColumn::make('first_payment')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->filters([
                //
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
            ])->defaultSort('start');
    }
}
