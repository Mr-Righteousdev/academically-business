<?php

namespace App\Filament\Resources\Contributions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContributionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('contributed_by')
                ->label('Contributed By')
                ->relationship('contributor', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->placeholder('Select contributor'),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('UGX'),
                TextInput::make('purpose')
                    ->maxLength(255)
                    ->placeholder('e.g. Buying business cards'),
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Textarea::make('notes')
                ->rows(3)
                ->placeholder('Any extra details...')
                ->columnSpanFull(),
            ]);
    }
}
