<?php

// app/Console/Commands/GenerateMonthlyReport.php
namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateMonthlyReport extends Command
{
    protected $signature = 'report:monthly {--month=} {--year=}';
    protected $description = 'Generate monthly business report';

    public function handle()
    {
        $month = $this->option('month') ?? now()->month;
        $year = $this->option('year') ?? now()->year;

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $this->info("Generating report for {$start->format('F Y')}...\n");

        // Revenue
        $revenue = Payment::whereBetween('payment_date', [$start, $end])->sum('amount');
        $this->info("💰 Total Revenue: UGX " . number_format($revenue));

        // Expenses
        $expenses = Expense::whereBetween('expense_date', [$start, $end])->sum('amount');
        $this->info("💸 Total Expenses: UGX " . number_format($expenses));

        // Profit
        $profit = $revenue - $expenses;
        $this->info("📈 Net Profit: UGX " . number_format($profit));
        $this->info("   Margin: " . ($revenue > 0 ? number_format(($profit/$revenue)*100, 1) : 0) . "%\n");

        // Projects
        $completed = Project::whereBetween('completed_at', [$start, $end])->count();
        $this->info("✅ Projects Completed: {$completed}");

        $started = Project::whereBetween('started_at', [$start, $end])->count();
        $this->info("🚀 Projects Started: {$started}\n");

        // Clients
        $newClients = Client::whereBetween('created_at', [$start, $end])->count();
        $this->info("👥 New Clients: {$newClients}");

        // Outstanding
        $outstanding = Project::where('balance', '>', 0)->sum('balance');
        $this->info("⏳ Outstanding Balance: UGX " . number_format($outstanding) . "\n");

        $this->info("Report generated successfully!");
    }
}
