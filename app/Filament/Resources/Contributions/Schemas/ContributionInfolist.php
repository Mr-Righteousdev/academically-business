<?php

namespace App\Filament\Resources\Contributions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContributionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('contributed_by')
                    ->numeric(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('purpose')
                    ->placeholder('-'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
