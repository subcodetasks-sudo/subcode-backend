<?php

namespace App\Filament\Widgets\Websites;

use App\Models\Website;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WebsitesVisitorCountsWidget extends BaseWidget
{
    protected static bool $isLazy = true;

    public function getStats(): array
    {
        $totalWebsites = Website::count();
        $websitesWithVisitors = Website::has('visitors')->count();
        $totalVisitors = Website::withCount('visitors')->get()->sum('visitors_count');

        return [
            Stat::make(__('admin.websites'), $totalWebsites)
                ->description(__('admin.total_websites'))
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('primary'),
            Stat::make(__('admin.websites_with_visitors'), $websitesWithVisitors)
                ->description(__('admin.websites_that_have_visitors'))
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
            Stat::make(__('admin.total_visitors'), $totalVisitors)
                ->description(__('admin.total_visitor_count'))
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}