<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TeamPerformance extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Team Performance';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->withCount([
                        'assignedProjects',
                        'assignedProjects as completed_projects_count' => function ($query) {
                            $query->whereIn('status', ['completed', 'delivered']);
                        }
                    ])
                    ->withSum('assignedProjects as total_revenue', 'total_paid')
                    ->withSum('assignedProjects as total_hours', 'actual_hours')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Team Member'),
                Tables\Columns\TextColumn::make('assigned_projects_count')
                    ->label('Total Projects')
                    ->badge(),
                Tables\Columns\TextColumn::make('completed_projects_count')
                    ->label('Completed')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('completion_rate')
                    ->label('Completion Rate')
                    ->getStateUsing(function ($record) {
                        $total = $record->assigned_projects_count;
                        $completed = $record->completed_projects_count;
                        return $total > 0 ? ($completed / $total) * 100 : 0;
                    })
                    ->formatStateUsing(fn ($state) => number_format($state, 1) . '%')
                    ->color(fn ($state) => $state > 80 ? 'success' : ($state > 50 ? 'warning' : 'danger')),
                Tables\Columns\TextColumn::make('total_hours')
                    ->label('Hours Logged')
                    ->suffix(' hrs'),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Revenue Generated')
                    ->money('UGX')
                    ->sortable(),
                Tables\Columns\TextColumn::make('revenue_per_hour')
                    ->label('UGX/Hour')
                    ->getStateUsing(function ($record) {
                        $hours = $record->total_hours ?? 0;
                        $revenue = $record->total_revenue ?? 0;
                        return $hours > 0 ? $revenue / $hours : 0;
                    })
                    ->money('UGX')
                    ->color('success'),
            ])
            ->paginated(false);
    }
}