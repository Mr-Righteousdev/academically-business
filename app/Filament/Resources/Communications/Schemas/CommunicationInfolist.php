<?php

namespace App\Filament\Resources\Communications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CommunicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('client.name')
                    ->label('Client'),
                TextEntry::make('project.title')
                    ->label('Project')
                    ->placeholder('-'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('direction')
                    ->badge(),
                TextEntry::make('summary')
                    ->columnSpanFull(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('communicated_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
