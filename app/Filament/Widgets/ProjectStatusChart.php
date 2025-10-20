<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProjectStatusChart extends ChartWidget
{
    protected ?string $heading = 'Projects by Status';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $statusCounts = Project::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'data' => array_values($statusCounts),
                    'backgroundColor' => [
                        '#6b7280',
                        '#3b82f6',
                        '#8b5cf6',
                        '#f59e0b',
                        '#10b981',
                        '#06b6d4',
                        '#22c55e',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => array_map('ucfirst', array_keys($statusCounts)),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}