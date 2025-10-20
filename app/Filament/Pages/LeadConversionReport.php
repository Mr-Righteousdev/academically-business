<?php

// app/Filament/Pages/LeadConversionReport.php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Lead;
use App\Models\Client;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

class LeadConversionReport extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-funnel';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Funnel;

    protected string $view = 'filament.pages.lead-conversion-report';
    // protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 3;

    public function getConversionData(): array
    {
        $totalLeads = Lead::count();
        $convertedLeads = Lead::where('status', 'won')->count();
        $lostLeads = Lead::where('status', 'lost')->count();
        
        $conversionRate = $totalLeads > 0 ? ($convertedLeads / $totalLeads) * 100 : 0;
        
        $conversionBySource = Lead::select('source', 
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "won" THEN 1 ELSE 0 END) as converted')
        )
        ->groupBy('source')
        ->get()
        ->map(function($item) {
            $item->conversion_rate = $item->total > 0 ? ($item->converted / $item->total) * 100 : 0;
            return $item;
        });

        $lostReasons = Lead::where('status', 'lost')
            ->select('lost_reason', DB::raw('COUNT(*) as count'))
            ->whereNotNull('lost_reason')
            ->groupBy('lost_reason')
            ->orderBy('count', 'desc')
            ->get();

        $avgTimeToConvert = Lead::where('status', 'won')
            ->whereNotNull('converted_at')
            ->selectRaw('AVG(DATEDIFF(converted_at, created_at)) as avg_days')
            ->value('avg_days');

        return [
            'totalLeads' => $totalLeads,
            'convertedLeads' => $convertedLeads,
            'lostLeads' => $lostLeads,
            'activeLeads' => $totalLeads - $convertedLeads - $lostLeads,
            'conversionRate' => $conversionRate,
            'conversionBySource' => $conversionBySource,
            'lostReasons' => $lostReasons,
            'avgTimeToConvert' => round($avgTimeToConvert ?? 0, 1),
        ];
    }
}
