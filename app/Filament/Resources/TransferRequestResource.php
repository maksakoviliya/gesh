<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\Transfer\ButtonDataEnum;
use App\Enums\Transfer\RequestStatusEnum;
use App\Filament\Resources\TransferRequestResource\Pages;
use App\Models\TransferRequest;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TransferRequestResource extends Resource
{
    protected static ?string $model = TransferRequest::class;

    protected static ?string $navigationGroup = 'Трансфер';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Запрос на трансфер')->columns()->schema([
                    Select::make('user')->relationship('user', 'name')
                        ->searchable()
                        ->columnSpan(2)
                        ->disabled(! Auth::user()->hasRole(['admin']))
                        ->getOptionLabelFromRecordUsing(fn (User $record) => "{$record->name} | {$record->phone}")
                        ->preload(),
                    Select::make('type')
                        ->options([
                            ButtonDataEnum::TAXI->value => ButtonDataEnum::TAXI->value,
                            ButtonDataEnum::TRANSFER->value => ButtonDataEnum::TRANSFER->value,
                        ])->columnSpan(1),
                    TextInput::make('passengers_count')->numeric()->columnSpan(1),
                    Select::make('status')
                        ->options([
                            RequestStatusEnum::DRAFT->value => RequestStatusEnum::DRAFT->value,
                            RequestStatusEnum::PENDING->value => RequestStatusEnum::PENDING->value,
                            RequestStatusEnum::APPROVED->value => RequestStatusEnum::APPROVED->value,
                            RequestStatusEnum::REJECTED->value => RequestStatusEnum::REJECTED->value,
                            RequestStatusEnum::CANCELLED->value => RequestStatusEnum::CANCELLED->value,
                        ]),
                    Forms\Components\DateTimePicker::make('start_at'),
                ]),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->description(fn (TransferRequest $record): string => $record->user?->phone?->formatE164() ?? '-')
                    ->url(function ($record) {
                        if (! Auth::user()->hasRole(['admin'])) {
                            return false;
                        }

                        if (! $record->user) {
                            return false;
                        }

                        return UserResource::getUrl('edit', ['record' => $record->user]);
                    })
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('status')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('start_at')->date('d.m.Y')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->date('d.m.Y H:i:s')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->date('d.m.Y H:i:s')->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        ButtonDataEnum::TAXI->value,
                        ButtonDataEnum::TRANSFER->value,
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        RequestStatusEnum::DRAFT->value,
                        RequestStatusEnum::PENDING->value,
                        RequestStatusEnum::APPROVED->value,
                        RequestStatusEnum::REJECTED->value,
                        RequestStatusEnum::CANCELLED->value,
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('start_at');
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
            'index' => Pages\ListTransferRequests::route('/'),
            'create' => Pages\CreateTransferRequest::route('/create'),
            'edit' => Pages\EditTransferRequest::route('/{record}/edit'),
        ];
    }
}
