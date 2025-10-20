<?php

namespace App\Filament\Widgets;

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
        
        // Active projects
        $activeProjects = Project::whereIn('status', ['in_progress', 'review', 'revision'])->count();
        
        // Outstanding balance
        $outstandingBalance = Project::where('balance', '>', 0)->sum('balance');
        
        // New clients this month
        $newClientsThisMonth = Client::whereDate('created_at', '>=', $currentMonth)->count();
        
        // Overdue projects
        $overdueProjects = Project::where('deadline', '<', now())
            ->whereNotIn('status', ['completed', 'delivered', 'cancelled'])
            ->count();

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
            
            Stat::make('Active Projects', $activeProjects)
                ->description($overdueProjects > 0 ? "{$overdueProjects} overdue" : 'All on track')
                ->descriptionIcon($overdueProjects > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($overdueProjects > 0 ? 'warning' : 'success'),
            
            Stat::make('Outstanding Balance', 'UGX ' . number_format($outstandingBalance))
                ->description('Money owed by clients')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('New Clients', $newClientsThisMonth)
                ->description('This month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
            
            Stat::make('Expenses', 'UGX ' . number_format($expensesThisMonth))
                ->description('This month')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),
        ];
    }
}
