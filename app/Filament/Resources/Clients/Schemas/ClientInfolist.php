<?php

namespace App\Filament\Resources\Clients\Schemas;

use App\Models\Client;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientInfolist
{
    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             TextEntry::make('name'),
    //             TextEntry::make('email')
    //                 ->label('Email address')
    //                 ->placeholder('-'),
    //             TextEntry::make('phone'),
    //             TextEntry::make('whatsapp')
    //                 ->placeholder('-'),
    //             TextEntry::make('program')
    //                 ->placeholder('-'),
    //             TextEntry::make('year_of_study')
    //                 ->placeholder('-'),
    //             TextEntry::make('source')
    //                 ->badge(),
    //             TextEntry::make('referral_source')
    //                 ->placeholder('-'),
    //             TextEntry::make('status')
    //                 ->badge(),
    //             TextEntry::make('notes')
    //                 ->placeholder('-')
    //                 ->columnSpanFull(),
    //             TextEntry::make('lifetime_value')
    //                 ->numeric(),
    //             TextEntry::make('projects_count')
    //                 ->numeric(),
    //             TextEntry::make('created_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //             TextEntry::make('updated_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //             TextEntry::make('deleted_at')
    //                 ->dateTime()
    //                 ->visible(fn (Client $record): bool => $record->trashed()),
    //         ]);
    // }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Client Overview')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->copyable(),
                        TextEntry::make('phone')
                            ->copyable(),
                        TextEntry::make('whatsapp')
                            ->copyable(),
                        TextEntry::make('program'),
                        TextEntry::make('year_of_study'),
                        TextEntry::make('source')
                            ->badge(),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('lifetime_value')
                            ->money('UGX'),
                        TextEntry::make('projects_count'),
                    ])->columns(2),
                
                Section::make('Notes')
                    ->schema([
                        TextEntry::make('notes')
                            ->placeholder('No notes yet'),
                    ]),
            ]);
    }
}
