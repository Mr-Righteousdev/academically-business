<?php

namespace App\Filament\Resources\Communications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CommunicationForm
{
    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             Select::make('client_id')
    //                 ->relationship('client', 'name')
    //                 ->required(),
    //             Select::make('project_id')
    //                 ->relationship('project', 'title')
    //                 ->default(null),
    //             Select::make('user_id')
    //                 ->relationship('user', 'name')
    //                 ->required(),
    //             Select::make('type')
    //                 ->options([
    //         'call' => 'Call',
    //         'whatsapp' => 'Whatsapp',
    //         'email' => 'Email',
    //         'sms' => 'Sms',
    //         'meeting' => 'Meeting',
    //         'other' => 'Other',
    //     ])
    //                 ->required(),
    //             Select::make('direction')
    //                 ->options(['inbound' => 'Inbound', 'outbound' => 'Outbound'])
    //                 ->required(),
    //             Textarea::make('summary')
    //                 ->required()
    //                 ->columnSpanFull(),
    //             Textarea::make('notes')
    //                 ->default(null)
    //                 ->columnSpanFull(),
    //             DateTimePicker::make('communicated_at')
    //                 ->required(),
    //         ]);
    // }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('client_id')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->required(),
                Select::make('project_id')
                    ->relationship('project', 'project_number')
                    ->searchable()
                    ->placeholder('Link to project (optional)'),
                Select::make('type')
                    ->options([
                        'call' => 'Phone Call',
                        'whatsapp' => 'WhatsApp',
                        'email' => 'Email',
                        'sms' => 'SMS',
                        'meeting' => 'Meeting',
                        'other' => 'Other',
                    ])
                    ->required(),
                Select::make('direction')
                    ->options([
                        'inbound' => 'Inbound (Client contacted us)',
                        'outbound' => 'Outbound (We contacted client)',
                    ])
                    ->required(),
                DateTimePicker::make('communicated_at')
                    ->required()
                    ->default(now()),
                Textarea::make('summary')
                    ->required()
                    ->rows(3)
                    ->placeholder('Brief summary of the conversation')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->rows(3)
                    ->placeholder('Additional notes or follow-up actions')
                    ->columnSpanFull(),
            ]);
    }
}
