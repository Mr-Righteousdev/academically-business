<?php

namespace App\Filament\Resources\Expenses\Widgets;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        
        // Revenue this month
        $revenueThisMonth = Payment::whereDate('payment_date', '>=', $currentMonth)->sum('amount');
        $revenueLastMonth = Payment::whereBetween('payment_date', [
            $lastMonth, 
            $currentMonth->copy()->subDay()
        ])->sum('amount');
        $revenueChange = $revenueLastMonth > 0 
            ? (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100 
            : 0;
        
        // Expenses this month
        $expensesThisMonth = Expense::whereDate('expense_date', '>=', $currentMonth)->sum('amount');
        
        return [
            Stat::make('Revenue This Month', 'UGX ' . number_format($revenueThisMonth))
                ->description($revenueChange > 0 ? "+{$revenueChange}% from last month" : "{$revenueChange}% from last month")
                ->descriptionIcon($revenueChange > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange > 0 ? 'success' : 'danger')
                ->chart([7, 4, 6, 9, 12, 8, 15]),
            
            Stat::make('Net Profit', 'UGX ' . number_format($revenueThisMonth - $expensesThisMonth))
                ->description('Revenue - Expenses')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color($revenueThisMonth > $expensesThisMonth ? 'success' : 'danger'),
            
            Stat::make('Expenses', 'UGX ' . number_format($expensesThisMonth))
                ->description('This month')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),
        ];
    }
}
