<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
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

class ProjectsTable
{
    // public static function configure(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             TextColumn::make('project_number')
    //                 ->searchable(),
    //             TextColumn::make('client.name')
    //                 ->searchable(),
    //             TextColumn::make('assigned_to')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('service_type')
    //                 ->badge(),
    //             TextColumn::make('title')
    //                 ->searchable(),
    //             TextColumn::make('quoted_price')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('agreed_price')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('deposit_paid')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('total_paid')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('balance')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('payment_status')
    //                 ->badge(),
    //             TextColumn::make('status')
    //                 ->badge(),
    //             TextColumn::make('deadline')
    //                 ->date()
    //                 ->sortable(),
    //             TextColumn::make('started_at')
    //                 ->date()
    //                 ->sortable(),
    //             TextColumn::make('completed_at')
    //                 ->date()
    //                 ->sortable(),
    //             TextColumn::make('delivered_at')
    //                 ->date()
    //                 ->sortable(),
    //             TextColumn::make('estimated_hours')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('actual_hours')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('priority')
    //                 ->badge(),
    //             TextColumn::make('revision_count')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('client_satisfaction')
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
                TextColumn::make('project_number')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('service_type')
                    ->badge()
                    ->colors([
                        'info' => 'programming',
                        'success' => 'coursework',
                        'warning' => 'research_paper',
                        'danger' => 'final_year_project',
                    ]),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'inquiry',
                        'info' => 'quoted',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                TextColumn::make('priority')
                    ->badge()
                    ->colors([
                        'secondary' => 'low',
                        'info' => 'medium',
                        'warning' => 'high',
                        'danger' => 'urgent',
                    ]),
                TextColumn::make('assignedUser.name')
                    ->label('Assigned')
                    ->toggleable(),
                TextColumn::make('deadline')
                    ->date()
                    ->sortable()
                    ->color(fn (Project $record) => $record->isOverdue() ? 'danger' : null),
                TextColumn::make('agreed_price')
                    ->money('UGX')
                    ->sortable(),
                TextColumn::make('balance')
                    ->money('UGX')
                    ->sortable()
                    ->color(fn ($state) => $state > 0 ? 'warning' : 'success'),
                TextColumn::make('payment_status')
                    ->badge()
                    ->colors([
                        'danger' => 'not_paid',
                        'warning' => 'deposit_paid',
                        'info' => 'partially_paid',
                        'success' => 'fully_paid',
                    ]),
            ])
            ->filters([
               SelectFilter::make('status'),
               SelectFilter::make('service_type'),
               SelectFilter::make('payment_status'),
               SelectFilter::make('assigned_to')
                    ->relationship('assignedUser', 'name'),
               Filter::make('overdue')
                    ->query(fn ($query) => $query->where('deadline', '<', now())
                        ->whereNotIn('status', ['completed', 'delivered', 'cancelled']))
                    ->label('Overdue Projects'),
               Filter::make('unpaid')
                    ->query(fn ($query) => $query->where('balance', '>', 0))
                    ->label('Has Balance'),
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
