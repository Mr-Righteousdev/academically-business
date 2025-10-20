<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ClientsTable
{
    // public static function configure(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             TextColumn::make('name')
    //                 ->searchable(),
    //             TextColumn::make('email')
    //                 ->label('Email address')
    //                 ->searchable(),
    //             TextColumn::make('phone')
    //                 ->searchable(),
    //             TextColumn::make('whatsapp')
    //                 ->searchable(),
    //             TextColumn::make('program')
    //                 ->searchable(),
    //             TextColumn::make('year_of_study')
    //                 ->searchable(),
    //             TextColumn::make('source')
    //                 ->badge(),
    //             TextColumn::make('referral_source')
    //                 ->searchable(),
    //             TextColumn::make('status')
    //                 ->badge(),
    //             TextColumn::make('lifetime_value')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('projects_count')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('created_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             TextColumn::make('updated_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             TextColumn::make('deleted_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //         ])
    //         ->filters([
    //             TrashedFilter::make(),
    //         ])
    //         ->recordActions([
    //             ViewAction::make(),
    //             EditAction::make(),
    //         ])
    //         ->toolbarActions([
    //             BulkActionGroup::make([
    //                 DeleteBulkAction::make(),
    //                 ForceDeleteBulkAction::make(),
    //                 RestoreBulkAction::make(),
    //             ]),
    //         ]);
    // }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('program')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'inquiry',
                        'warning' => 'negotiating',
                        'success' => 'active',
                        'primary' => 'completed',
                        'danger' => 'inactive',
                    ]),
                TextColumn::make('source')
                    ->badge()
                    ->colors([
                        'info' => 'website',
                        'success' => 'referral',
                        'warning' => 'whatsapp_group',
                    ]),
                TextColumn::make('projects_count')
                    ->label('Projects')
                    ->badge()
                    ->sortable(),
                TextColumn::make('lifetime_value')
                    ->label('LTV')
                    ->money('UGX')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status'),
                SelectFilter::make('source'),
                Filter::make('high_value')
                    ->query(fn ($query) => $query->where('lifetime_value', '>', 500000))
                    ->label('High Value (>500K)'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
