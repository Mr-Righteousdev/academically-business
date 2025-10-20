<?php

namespace App\Filament\Resources\Communications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommunicationsTable
{
    // public static function configure(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             TextColumn::make('client.name')
    //                 ->searchable(),
    //             TextColumn::make('project.title')
    //                 ->searchable(),
    //             TextColumn::make('user.name')
    //                 ->searchable(),
    //             TextColumn::make('type')
    //                 ->badge(),
    //             TextColumn::make('direction')
    //                 ->badge(),
    //             TextColumn::make('communicated_at')
    //                 ->dateTime()
    //                 ->sortable(),
    //             TextColumn::make('created_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             TextColumn::make('updated_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->recordActions([
    //             ViewAction::make(),
    //             EditAction::make(),
    //         ])
    //         ->toolbarActions([
    //             BulkActionGroup::make([
    //                 DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('communicated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('client.name')
                    ->searchable(),
                TextColumn::make('project.project_number')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('type')
                    ->colors([
                        'info' => 'call',
                        'success' => 'whatsapp',
                        'warning' => 'email',
                    ]),
                TextColumn::make('direction')
                    ->colors([
                        'info' => 'inbound',
                        'warning' => 'outbound',
                    ]),
                TextColumn::make('summary')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Handled By'),
            ])
            ->filters([
                SelectFilter::make('type'),
                SelectFilter::make('direction'),
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Handled By'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('communicated_at', 'desc');
    }
}
