<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ServiceTypeBreakdown extends ChartWidget
{
    protected ?string $heading = 'Revenue by Service Type';
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $serviceRevenue = Project::select('service_type', DB::raw('SUM(total_paid) as revenue'))
            ->groupBy('service_type')
            ->orderBy('revenue', 'desc')
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $serviceRevenue->pluck('revenue')->toArray(),
                    'backgroundColor' => [
                        '#3b82f6',
                        '#8b5cf6',
                        '#f59e0b',
                        '#10b981',
                        '#06b6d4',
                        '#ef4444',
                        '#ec4899',
                        '#6b7280',
                    ],
                ],
            ],
            'labels' => $serviceRevenue->pluck('service_type')->map(fn($type) => ucwords(str_replace('_', ' ', $type)))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
