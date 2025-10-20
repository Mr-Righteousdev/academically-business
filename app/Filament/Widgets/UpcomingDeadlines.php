<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingDeadlines extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->whereIn('status', ['in_progress', 'review', 'revision'])
                    ->where('deadline', '>=', now())
                    ->orderBy('deadline', 'asc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('project_number')
                    ->label('Project #'),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('title')
                    ->limit(40),
                Tables\Columns\TextColumn::make('assignedUser.name')
                    ->label('Assigned To'),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->color(function ($record) {
                        $daysUntil = now()->diffInDays($record->deadline, false);
                        if ($daysUntil < 2) return 'danger';
                        if ($daysUntil < 5) return 'warning';
                        return 'success';
                    }),
                Tables\Columns\BadgeColumn::make('priority')
                    ->colors([
                        'secondary' => 'low',
                        'info' => 'medium',
                        'warning' => 'high',
                        'danger' => 'urgent',
                    ]),
            ])
            ->heading('Upcoming Deadlines');
    }
}
