<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentProjects extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('project_number')
                    ->label('Project #'),
                Tables\Columns\TextColumn::make('client.name'),
                Tables\Columns\TextColumn::make('title')
                    ->limit(40),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'inquiry',
                        'info' => 'quoted',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                    ]),
                Tables\Columns\TextColumn::make('deadline')
                    ->date(),
                Tables\Columns\TextColumn::make('agreed_price')
                    ->money('UGX'),
            ])
            ->heading('Recent Projects');
    }
}
