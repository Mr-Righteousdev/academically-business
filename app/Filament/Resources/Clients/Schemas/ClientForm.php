<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;

class ClientForm
{
    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             TextInput::make('name')
    //                 ->required(),
    //             TextInput::make('email')
    //                 ->label('Email address')
    //                 ->email()
    //                 ->default(null),
    //             TextInput::make('phone')
    //                 ->tel()
    //                 ->required(),
    //             TextInput::make('whatsapp')
    //                 ->default(null),
    //             TextInput::make('program')
    //                 ->default(null),
    //             TextInput::make('year_of_study')
    //                 ->default(null),
    //             Select::make('source')
    //                 ->options([
    //         'flyer' => 'Flyer',
    //         'business_card' => 'Business card',
    //         'whatsapp_group' => 'Whatsapp group',
    //         'facebook' => 'Facebook',
    //         'referral' => 'Referral',
    //         'website' => 'Website',
    //         'walk_in' => 'Walk in',
    //         'other' => 'Other',
    //     ])
    //                 ->default('other')
    //                 ->required(),
    //             TextInput::make('referral_source')
    //                 ->default(null),
    //             Select::make('status')
    //                 ->options([
    //         'inquiry' => 'Inquiry',
    //         'negotiating' => 'Negotiating',
    //         'active' => 'Active',
    //         'completed' => 'Completed',
    //         'inactive' => 'Inactive',
    //     ])
    //                 ->default('inquiry')
    //                 ->required(),
    //             Textarea::make('notes')
    //                 ->default(null)
    //                 ->columnSpanFull(),
    //             TextInput::make('lifetime_value')
    //                 ->required()
    //                 ->numeric()
    //                 ->default(0.0),
    //             TextInput::make('projects_count')
    //                 ->required()
    //                 ->numeric()
    //                 ->default(0),
    //         ]);
    // }

    public static function configure(Schema $schema)
    {
        return $schema
            ->schema([
                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('whatsapp')
                            ->tel()
                            ->maxLength(255)
                            ->placeholder('If different from phone'),
                    ])->columns(2),

                Section::make('Academic Details')
                    ->schema([
                        TextInput::make('program')
                            ->maxLength(255)
                            ->placeholder('e.g., Computer Science'),
                        Select::make('year_of_study')
                            ->options([
                                'Year 1' => 'Year 1',
                                'Year 2' => 'Year 2',
                                'Year 3' => 'Year 3',
                                'Year 4' => 'Year 4',
                                'Year 5' => 'Year 5',
                                'Masters' => 'Masters',
                                'PhD' => 'PhD',
                            ]),
                    ])->columns(2),

                Section::make('Business Information')
                    ->schema([
                        Select::make('source')
                            ->options([
                                'flyer' => 'Flyer',
                                'business_card' => 'Business Card',
                                'whatsapp_group' => 'WhatsApp Group',
                                'facebook' => 'Facebook',
                                'referral' => 'Referral',
                                'website' => 'Website',
                                'walk_in' => 'Walk In',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->default('other'),
                        TextInput::make('referral_source')
                            ->maxLength(255)
                            ->placeholder('Who referred this client?')
                            ->visible(fn (Get $get) => $get('source') === 'referral'),
                        Select::make('status')
                            ->options([
                                'inquiry' => 'Inquiry',
                                'negotiating' => 'Negotiating',
                                'active' => 'Active',
                                'completed' => 'Completed',
                                'inactive' => 'Inactive',
                            ])
                            ->required()
                            ->default('inquiry'),
                        Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
