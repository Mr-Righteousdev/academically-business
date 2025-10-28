<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Contribution;
use App\Models\Disbursement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BusinessStatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    protected ?string $heading = 'Business Financial Overview';

    protected function getStats(): array
    {
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();

        // 🔹 Revenue (This Month + Change)
        $revenueThisMonth = Payment::whereDate('payment_date', '>=', $currentMonth)->sum('amount');
        $revenueLastMonth = Payment::whereBetween('payment_date', [$lastMonth, $currentMonth->copy()->subDay()])->sum('amount');
        $revenueChange = $revenueLastMonth > 0
            ? (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100
            : 0;

        // 🔹 Totals
        $totalRevenue = Payment::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalContributions = Contribution::sum('amount');
        $totalDisbursed = Disbursement::sum('amount');

        // 🔹 Monthly expenses
        $expensesThisMonth = Expense::whereDate('expense_date', '>=', $currentMonth)->sum('amount');

        // 🔹 Business Bank Balance
        $businessBalance = ($totalRevenue + $totalContributions) - ($totalExpenses + $totalDisbursed);

        // 🔹 Net Profit (This Month)
        $netProfitThisMonth = $revenueThisMonth - $expensesThisMonth;

        return [
            // --- Monthly Performance ---
            Stat::make('Revenue This Month', 'UGX ' . number_format($revenueThisMonth))
                ->description($revenueChange > 0 ? "+{$revenueChange}% from last month" : "{$revenueChange}% from last month")
                ->descriptionIcon($revenueChange > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange > 0 ? 'success' : 'danger')
                ->chart([7, 4, 6, 9, 12, 8, 15]),

            Stat::make('Net Profit This Month', 'UGX ' . number_format($netProfitThisMonth))
                ->description('Revenue - Expenses (This Month)')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color($netProfitThisMonth >= 0 ? 'success' : 'danger'),

            // --- Lifetime Totals ---
            Stat::make('Total Revenue', 'UGX ' . number_format($totalRevenue))
                ->description('All client payments received')
                ->descriptionIcon('heroicon-m-arrow-up-circle')
                ->color('success'),

            Stat::make('Total Contributions', 'UGX ' . number_format($totalContributions))
                ->description('Funds added by members')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Total Expenses', 'UGX ' . number_format($totalExpenses))
                ->description('Total money spent')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),

            Stat::make('Total Disbursed', 'UGX ' . number_format($totalDisbursed))
                ->description('Money shared among members')
                ->descriptionIcon('heroicon-m-hand-thumb-up')
                ->color('warning'),

            // --- Business Bank Balance ---
            Stat::make('Business Balance', 'UGX ' . number_format($businessBalance))
                ->description('Available funds (Revenue + Contributions - Expenses - Disbursements)')
                ->descriptionIcon('heroicon-m-briefcase')
                ->columnSpan(2)
                ->color($businessBalance >= 0 ? 'success' : 'danger'),
        ];
    }
}
