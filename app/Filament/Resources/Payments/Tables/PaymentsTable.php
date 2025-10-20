<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('project.project_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.name')
                    ->searchable(),
                TextColumn::make('amount')
                    ->money('UGX')
                    ->sortable(),
                TextColumn::make('payment_type')
                    ->badge()
                    ->colors([
                        'info' => 'deposit',
                        'warning' => 'partial',
                        'success' => 'full',
                        'primary' => 'balance',
                    ]),
                TextColumn::make('payment_method')
                    ->badge(),
                TextColumn::make('transaction_reference')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('recordedBy.name')
                    ->label('Recorded By')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('payment_method'),
                SelectFilter::make('payment_type'),
                Filter::make('payment_date')
                    ->schema([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('payment_date', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('payment_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            // ->toolbarActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ])
            ->defaultSort('payment_date', 'desc');
    }
}
