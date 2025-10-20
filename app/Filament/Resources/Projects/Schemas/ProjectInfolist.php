<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    // public static function configure(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             TextEntry::make('project_number'),
    //             TextEntry::make('client.name')
    //                 ->label('Client'),
    //             TextEntry::make('assigned_to')
    //                 ->numeric()
    //                 ->placeholder('-'),
    //             TextEntry::make('service_type')
    //                 ->badge(),
    //             TextEntry::make('title'),
    //             TextEntry::make('description')
    //                 ->placeholder('-')
    //                 ->columnSpanFull(),
    //             TextEntry::make('requirements')
    //                 ->placeholder('-')
    //                 ->columnSpanFull(),
    //             TextEntry::make('quoted_price')
    //                 ->numeric()
    //                 ->placeholder('-'),
    //             TextEntry::make('agreed_price')
    //                 ->numeric()
    //                 ->placeholder('-'),
    //             TextEntry::make('deposit_paid')
    //                 ->numeric(),
    //             TextEntry::make('total_paid')
    //                 ->numeric(),
    //             TextEntry::make('balance')
    //                 ->numeric(),
    //             TextEntry::make('payment_status')
    //                 ->badge(),
    //             TextEntry::make('status')
    //                 ->badge(),
    //             TextEntry::make('deadline')
    //                 ->date()
    //                 ->placeholder('-'),
    //             TextEntry::make('started_at')
    //                 ->date()
    //                 ->placeholder('-'),
    //             TextEntry::make('completed_at')
    //                 ->date()
    //                 ->placeholder('-'),
    //             TextEntry::make('delivered_at')
    //                 ->date()
    //                 ->placeholder('-'),
    //             TextEntry::make('estimated_hours')
    //                 ->numeric()
    //                 ->placeholder('-'),
    //             TextEntry::make('actual_hours')
    //                 ->numeric(),
    //             TextEntry::make('priority')
    //                 ->badge(),
    //             TextEntry::make('revision_count')
    //                 ->numeric(),
    //             TextEntry::make('client_satisfaction')
    //                 ->numeric()
    //                 ->placeholder('-'),
    //             TextEntry::make('created_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //             TextEntry::make('updated_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //             TextEntry::make('deleted_at')
    //                 ->dateTime()
    //                 ->visible(fn (Project $record): bool => $record->trashed()),
    //         ]);
    // }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Project Information')
                    ->schema([
                        TextEntry::make('project_number'),
                        TextEntry::make('client.name'),
                        TextEntry::make('assignedUser.name'),
                        TextEntry::make('service_type')->badge(),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('priority')->badge(),
                        TextEntry::make('deadline')->date(),
                        TextEntry::make('started_at')->date(),
                    ])->columns(2),

                Section::make('Financial Details')
                    ->schema([
                        TextEntry::make('quoted_price')->money('UGX'),
                        TextEntry::make('agreed_price')->money('UGX'),
                        TextEntry::make('total_paid')->money('UGX'),
                        TextEntry::make('balance')->money('UGX'),
                        TextEntry::make('payment_status')->badge(),
                    ])->columns(3),

                Section::make('Work Details')
                    ->schema([
                        TextEntry::make('title')->columnSpanFull(),
                        TextEntry::make('description')->columnSpanFull(),
                        TextEntry::make('requirements')->columnSpanFull(),
                    ]),

                Section::make('Performance Metrics')
                    ->schema([
                        TextEntry::make('estimated_hours')->suffix(' hrs'),
                        TextEntry::make('actual_hours')->suffix(' hrs'),
                        TextEntry::make('revision_count'),
                        TextEntry::make('client_satisfaction')->suffix(' / 5'),
                    ])->columns(4),
            ]);
    }
}
