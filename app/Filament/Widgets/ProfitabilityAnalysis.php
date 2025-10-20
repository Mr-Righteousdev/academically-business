<?php

// app/Filament/Widgets/ProfitabilityAnalysis.php
namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProfitabilityAnalysis extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Project Profitability Analysis';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->whereIn('status', ['completed', 'delivered'])
                    ->with(['expenses', 'timeLogs'])
                    ->latest()
                    ->limit(20)
            )
            ->columns([
                Tables\Columns\TextColumn::make('project_number')
                    ->label('Project #'),
                Tables\Columns\TextColumn::make('title')
                    ->limit(30),
                Tables\Columns\TextColumn::make('service_type')
                    ->badge(),
                Tables\Columns\TextColumn::make('total_paid')
                    ->label('Revenue')
                    ->money('UGX')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expenses_sum')
                    ->label('Direct Costs')
                    ->money('UGX')
                    ->getStateUsing(fn ($record) => $record->expenses->sum('amount')),
                Tables\Columns\TextColumn::make('actual_hours')
                    ->label('Hours')
                    ->suffix(' hrs'),
                Tables\Columns\TextColumn::make('labor_cost')
                    ->label('Labor Cost')
                    ->money('UGX')
                    ->getStateUsing(fn ($record) => $record->actual_hours * 10000), // 10k per hour
                Tables\Columns\TextColumn::make('profit')
                    ->label('Net Profit')
                    ->money('UGX')
                    ->getStateUsing(function ($record) {
                        $revenue = $record->total_paid;
                        $directCosts = $record->expenses->sum('amount');
                        $laborCost = $record->actual_hours * 10000;
                        return $revenue - $directCosts - $laborCost;
                    })
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('margin')
                    ->label('Margin %')
                    ->getStateUsing(function ($record) {
                        $revenue = $record->total_paid;
                        if ($revenue == 0) return 0;
                        $directCosts = $record->expenses->sum('amount');
                        $laborCost = $record->actual_hours * 10000;
                        $profit = $revenue - $directCosts - $laborCost;
                        return ($profit / $revenue) * 100;
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 1) . '%')
                    ->color(fn ($state) => $state > 50 ? 'success' : ($state > 20 ? 'warning' : 'danger'))
                    ->sortable(),
            ]);
    }
}