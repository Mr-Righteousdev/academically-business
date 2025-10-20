<?php 

// app/Filament/Widgets/ClientSourceAnalysis.php
namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ClientSourceAnalysis extends ChartWidget
{
    protected ?string $heading = 'Client Acquisition by Source';
    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $sourceCounts = Client::select('source', DB::raw('COUNT(*) as count'))
            ->groupBy('source')
            ->orderBy('count', 'desc')
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $sourceCounts->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#10b981',
                        '#3b82f6',
                        '#f59e0b',
                        '#8b5cf6',
                        '#06b6d4',
                        '#ef4444',
                        '#ec4899',
                        '#6b7280',
                    ],
                ],
            ],
            'labels' => $sourceCounts->pluck('source')->map(fn($s) => ucwords(str_replace('_', ' ', $s)))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}