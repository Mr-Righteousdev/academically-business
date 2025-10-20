<?php

namespace App\Filament\Resources\Leads\Schemas;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;

class LeadForm
{
    public static function configure(Schema $schema): Schema
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
                            ->maxLength(255),
                        TextInput::make('whatsapp')
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Lead Information')
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
                            ->required(),
                        Select::make('status')
                            ->options([
                                'new' => 'New',
                                'contacted' => 'Contacted',
                                'qualified' => 'Qualified',
                                'quoted' => 'Quoted',
                                'negotiating' => 'Negotiating',
                                'won' => 'Won',
                                'lost' => 'Lost',
                            ])
                            ->required()
                            ->default('new'),
                        TextInput::make('service_interested')
                            ->maxLength(255)
                            ->placeholder('What service are they interested in?'),
                        Select::make('lost_reason')
                            ->options([
                                'too_expensive' => 'Too Expensive',
                                'deadline_too_tight' => 'Deadline Too Tight',
                                'went_with_competitor' => 'Went With Competitor',
                                'no_response' => 'No Response',
                                'changed_mind' => 'Changed Mind',
                                'other' => 'Other',
                            ])
                            ->visible(fn (Get $get) => $get('status') === 'lost'),
                    ])->columns(2),

                Section::make('Inquiry Details')
                    ->schema([
                        Textarea::make('inquiry_details')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
