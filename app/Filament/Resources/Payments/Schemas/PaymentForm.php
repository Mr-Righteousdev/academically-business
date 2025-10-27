<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Project;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Utilities\Set;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('project_id')
                    ->relationship('project', 'title')
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Set $set) {
                        if ($state) {
                            $project = Project::find($state);
                            $set('client_id', $project->client_id);
                        }
                    }),
                Select::make('client_id')
                    ->relationship('client', 'name')
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
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
                TextInput::make('transaction_reference')
                    ->maxLength(255)
                    ->placeholder('Transaction ID or reference'),
                DatePicker::make('payment_date')
                    ->required()
                    ->default(now()),
                Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
