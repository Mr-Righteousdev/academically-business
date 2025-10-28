<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Expense;
use App\Models\Contribution;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BusinessBalanceStat extends BaseWidget
{
    protected static ?int $sort = 0;
    protected ?string $heading = 'Business Balance Overview';

    protected function getStats(): array
    {
        $totalRevenue = Payment::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalContributions = Contribution::sum('amount');

        $businessBalance = ($totalRevenue + $totalContributions) - $totalExpenses;

        return [
            Stat::make('Total Revenue', 'UGX ' . number_format($totalRevenue))
                ->description('All client payments received')
                ->color('success')
                ->icon('heroicon-m-currency-dollar'),

            Stat::make('Total Contributions', 'UGX ' . number_format($totalContributions))
                ->description('Funds added by members')
                ->color('info')
                ->icon('heroicon-m-user-group'),

            Stat::make('Total Expenses', 'UGX ' . number_format($totalExpenses))
                ->description('Total money spent')
                ->color('danger')
                ->icon('heroicon-m-banknotes'),

            Stat::make('Business Balance', 'UGX ' . number_format($businessBalance))
                ->description('Available funds (Revenue + Contributions - Expenses)')
                ->color($businessBalance >= 0 ? 'success' : 'danger')
                ->icon('heroicon-m-briefcase'),
        ];
    }
}
