<?php

namespace App\Filament\Widgets;

use App\Models\Contribution;
use Filament\Widgets\ChartWidget;

class ContributionsChart extends ChartWidget
{
    protected ?string $heading = 'Member Contributions (Last 6 Months)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i));

        $contributionData = $months->map(function ($month) {
            return Contribution::whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Contributions',
                    'data' => $contributionData->toArray(),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#2563eb',
                ],
            ],
            'labels' => $months->map(fn($m) => $m->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
