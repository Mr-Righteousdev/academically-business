<?php

// app/Filament/Pages/FinancialReport.php
namespace App\Filament\Pages;

use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use Carbon\Carbon;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

class FinancialReport extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;

    protected string $view = 'filament.pages.financial-report';
    // protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 2;

    public $startDate;
    public $endDate;
    public $reportData;

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();
        $this->generateReport();
    }

    public function generateReport(): void
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);

        // Revenue
        $totalRevenue = Payment::whereBetween('payment_date', [$start, $end])->sum('amount');
        $cashRevenue = Payment::whereBetween('payment_date', [$start, $end])
            ->where('payment_method', 'cash')
            ->sum('amount');
        $mobileMoneyRevenue = Payment::whereBetween('payment_date', [$start, $end])
            ->where('payment_method', 'mobile_money')
            ->sum('amount');

        // Expenses
        $totalExpenses = Expense::whereBetween('expense_date', [$start, $end])->sum('amount');
        $expensesByCategory = Expense::whereBetween('expense_date', [$start, $end])
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        // Projects
        $projectsCompleted = Project::whereBetween('completed_at', [$start, $end])
            ->whereIn('status', ['completed', 'delivered'])
            ->count();
        $projectsStarted = Project::whereBetween('started_at', [$start, $end])->count();

        // Outstanding
        $outstandingBalance = Project::where('balance', '>', 0)->sum('balance');
        $overdueProjects = Project::where('deadline', '<', now())
            ->whereNotIn('status', ['completed', 'delivered', 'cancelled'])
            ->count();

        $this->reportData = [
            'totalRevenue' => $totalRevenue,
            'cashRevenue' => $cashRevenue,
            'mobileMoneyRevenue' => $mobileMoneyRevenue,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $totalRevenue - $totalExpenses,
            'profitMargin' => $totalRevenue > 0 ? (($totalRevenue - $totalExpenses) / $totalRevenue) * 100 : 0,
            'expensesByCategory' => $expensesByCategory,
            'projectsCompleted' => $projectsCompleted,
            'projectsStarted' => $projectsStarted,
            'outstandingBalance' => $outstandingBalance,
            'overdueProjects' => $overdueProjects,
        ];
    }
}
