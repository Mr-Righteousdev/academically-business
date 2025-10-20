<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             TextInput::make('project_number')
    //                 ->required(),
    //             Select::make('client_id')
    //                 ->relationship('client', 'name')
    //                 ->required(),
    //             TextInput::make('assigned_to')
    //                 ->numeric()
    //                 ->default(null),
    //             Select::make('service_type')
    //                 ->options([
    //         'coursework' => 'Coursework',
    //         'research_paper' => 'Research paper',
    //         'final_year_project' => 'Final year project',
    //         'programming' => 'Programming',
    //         'data_analysis' => 'Data analysis',
    //         'presentation' => 'Presentation',
    //         'thesis' => 'Thesis',
    //         'other' => 'Other',
    //     ])
    //                 ->required(),
    //             TextInput::make('title')
    //                 ->required(),
    //             Textarea::make('description')
    //                 ->default(null)
    //                 ->columnSpanFull(),
    //             Textarea::make('requirements')
    //                 ->default(null)
    //                 ->columnSpanFull(),
    //             TextInput::make('quoted_price')
    //                 ->numeric()
    //                 ->default(null),
    //             TextInput::make('agreed_price')
    //                 ->numeric()
    //                 ->default(null),
    //             TextInput::make('deposit_paid')
    //                 ->required()
    //                 ->numeric()
    //                 ->default(0.0),
    //             TextInput::make('total_paid')
    //                 ->required()
    //                 ->numeric()
    //                 ->default(0.0),
    //             TextInput::make('balance')
    //                 ->required()
    //                 ->numeric()
    //                 ->default(0.0),
    //             Select::make('payment_status')
    //                 ->options([
    //         'not_paid' => 'Not paid',
    //         'deposit_paid' => 'Deposit paid',
    //         'partially_paid' => 'Partially paid',
    //         'fully_paid' => 'Fully paid',
    //     ])
    //                 ->default('not_paid')
    //                 ->required(),
    //             Select::make('status')
    //                 ->options([
    //         'inquiry' => 'Inquiry',
    //         'quoted' => 'Quoted',
    //         'accepted' => 'Accepted',
    //         'in_progress' => 'In progress',
    //         'review' => 'Review',
    //         'revision' => 'Revision',
    //         'completed' => 'Completed',
    //         'delivered' => 'Delivered',
    //         'cancelled' => 'Cancelled',
    //     ])
    //                 ->default('inquiry')
    //                 ->required(),
    //             DatePicker::make('deadline'),
    //             DatePicker::make('started_at'),
    //             DatePicker::make('completed_at'),
    //             DatePicker::make('delivered_at'),
    //             TextInput::make('estimated_hours')
    //                 ->numeric()
    //                 ->default(null),
    //             TextInput::make('actual_hours')
    //                 ->required()
    //                 ->numeric()
    //                 ->default(0),
    //             Select::make('priority')
    //                 ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'])
    //                 ->default('medium')
    //                 ->required(),
    //             TextInput::make('revision_count')
    //                 ->required()
    //                 ->numeric()
    //                 ->default(0),
    //             TextInput::make('client_satisfaction')
    //                 ->numeric()
    //                 ->default(null),
    //         ]);
    // }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Project Details')
                    ->schema([
                        Select::make('client_id')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')->required(),
                                TextInput::make('phone')->required(),
                                TextInput::make('email')->email(),
                            ]),
                        Select::make('assigned_to')
                            ->relationship('assignedUser', 'name')
                            ->searchable()
                            ->placeholder('Assign to team member'),
                        Select::make('service_type')
                            ->options([
                                'coursework' => 'Coursework',
                                'research_paper' => 'Research Paper',
                                'final_year_project' => 'Final Year Project',
                                'programming' => 'Programming',
                                'data_analysis' => 'Data Analysis',
                                'presentation' => 'Presentation',
                                'thesis' => 'Thesis',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ])
                            ->default('medium')
                            ->required(),
                    ])->columns(2),

                Section::make('Work Description')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('requirements')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Pricing & Payment')
                    ->schema([
                        TextInput::make('quoted_price')
                            ->numeric()
                            ->prefix('UGX')
                            ->placeholder('Initial quote'),
                        TextInput::make('agreed_price')
                            ->numeric()
                            ->prefix('UGX')
                            ->placeholder('Final agreed amount')
                            ->required(),
                        TextInput::make('deposit_paid')
                            ->numeric()
                            ->prefix('UGX')
                            ->default(0),
                        Select::make('payment_status')
                            ->options([
                                'not_paid' => 'Not Paid',
                                'deposit_paid' => 'Deposit Paid',
                                'partially_paid' => 'Partially Paid',
                                'fully_paid' => 'Fully Paid',
                            ])
                            ->default('not_paid'),
                    ])->columns(2),

                Section::make('Timeline & Status')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'inquiry' => 'Inquiry',
                                'quoted' => 'Quoted',
                                'accepted' => 'Accepted',
                                'in_progress' => 'In Progress',
                                'review' => 'Review',
                                'revision' => 'Revision',
                                'completed' => 'Completed',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('inquiry'),
                        DatePicker::make('deadline')
                            ->required(),
                        DatePicker::make('started_at'),
                        DatePicker::make('completed_at'),
                        TextInput::make('estimated_hours')
                            ->numeric()
                            ->suffix('hours')
                            ->placeholder('Est. time needed'),
                        TextInput::make('client_satisfaction')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->suffix('/ 5')
                            ->placeholder('Rate 1-5'),
                    ])->columns(3),
            ]);
    }
}
