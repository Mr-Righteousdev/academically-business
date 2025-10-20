<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected ?string $heading = 'Revenue vs Expenses (Last 6 Months)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function ($monthsAgo) {
            return now()->subMonths($monthsAgo);
        });

        $revenueData = $months->map(function ($month) {
            return Payment::whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount');
        });

        $expenseData = $months->map(function ($month) {
            return Expense::whereYear('expense_date', $month->year)
                ->whereMonth('expense_date', $month->month)
                ->sum('amount');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $revenueData->toArray(),
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#10b981',
                ],
                [
                    'label' => 'Expenses',
                    'data' => $expenseData->toArray(),
                    'backgroundColor' => '#ef4444',
                    'borderColor' => '#ef4444',
                ],
            ],
            'labels' => $months->map(fn($month) => $month->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
