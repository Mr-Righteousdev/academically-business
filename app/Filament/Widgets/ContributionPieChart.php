<?php

namespace App\Filament\Widgets;

use App\Models\Contribution;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class ContributionPieChart extends ChartWidget
{
    protected ?string $heading = 'Contributions by User';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 1;
    protected function getData(): array
    {
        // Get total contributions grouped by user
        $contributions = Contribution::selectRaw('contributed_by, SUM(amount) as total')
            ->groupBy('contributed_by')
            ->get();

        $labels = [];
        $data = [];

        foreach ($contributions as $contribution) {
            $user = User::find($contribution->contributed_by);
            $labels[] = $user ? $user->name : 'Unknown User';
            $data[] = $contribution->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Contributions',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#10b981', // green
                        '#f59e0b', // yellow
                        '#ef4444', // red
                        '#8b5cf6', // purple
                        '#06b6d4', // cyan
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
