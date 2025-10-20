<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class ExpensesTable
{
    // public static function configure(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             TextColumn::make('user.name')
    //                 ->searchable(),
    //             TextColumn::make('project.title')
    //                 ->searchable(),
    //             TextColumn::make('category')
    //                 ->badge(),
    //             TextColumn::make('amount')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('expense_date')
    //                 ->date()
    //                 ->sortable(),
    //             TextColumn::make('receipt_path')
    //                 ->searchable(),
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
                TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge()
                    ->colors([
                        'danger' => 'printing',
                        'warning' => 'data_bundle',
                        'info' => 'transport',
                        'success' => 'marketing',
                    ]),
                TextColumn::make('description')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('project.project_number')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('amount')
                    ->money('UGX')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Recorded By')
                    ->toggleable(),
                IconColumn::make('receipt_path')
                    ->label('Receipt')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                SelectFilter::make('category'),
                Filter::make('expense_date')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('expense_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('expense_date', '<=', $date));
                    }),
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
            ->defaultSort('expense_date', 'desc');
    }

}
