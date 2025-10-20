<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $relatedResource = PaymentResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('amount')
                    ->numeric()
                    ->prefix('UGX')
                    ->required(),
                Select::make('payment_type')
                    ->options([
                        'deposit' => 'Deposit',
                        'partial' => 'Partial Payment',
                        'full' => 'Full Payment',
                        'balance' => 'Balance',
                    ])
                    ->required(),
                Select::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        'mobile_money' => 'Mobile Money',
                        'bank_transfer' => 'Bank Transfer',
                        'other' => 'Other',
                    ])
                    ->required(),
                TextInput::make('transaction_reference'),
                DatePicker::make('payment_date')
                    ->required()
                    ->default(now()),
                Textarea::make('notes')->rows(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_date')->date()->sortable(),
                TextColumn::make('amount')->money('UGX'),
                TextColumn::make('payment_type')->badge(),
                TextColumn::make('payment_method')->badge(),
                TextColumn::make('transaction_reference'),
            ])
            ->defaultSort('payment_date', 'desc')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
