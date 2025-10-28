<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
   
    
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
            \App\Filament\Widgets\BusinessBalanceStat::class,
            \App\Filament\Widgets\RevenueChart::class,
            \App\Filament\Widgets\ProjectStatusChart::class,
            \App\Filament\Widgets\RecentProjects::class,
            \App\Filament\Widgets\UpcomingDeadlines::class,           
            \App\Filament\Widgets\ContributionsChart::class,
        ];
    }
}