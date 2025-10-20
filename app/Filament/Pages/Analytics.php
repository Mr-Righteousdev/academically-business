<?php

// app/Filament/Pages/Analytics.php
namespace App\Filament\Pages;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Analytics extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected string $view = 'filament.pages.analytics';
    // protected ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 1;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\ServiceTypeBreakdown::class,
            \App\Filament\Widgets\ClientSourceAnalysis::class,
            \App\Filament\Widgets\TeamPerformance::class,
            \App\Filament\Widgets\ProfitabilityAnalysis::class,
        ];
    }
}
