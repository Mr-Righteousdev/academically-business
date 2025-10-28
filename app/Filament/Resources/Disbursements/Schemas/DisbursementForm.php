<?php

namespace App\Filament\Resources\Disbursements\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DisbursementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('recorded_by')
                    ->numeric()
                    ->default(null),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                DatePicker::make('disbursed_on')
                    ->required(),
                TextInput::make('method')
                    ->default(null),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
