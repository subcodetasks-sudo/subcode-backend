<?php

namespace App\Filament\Resources\Websites\Widgets;

use App\Models\Visitor;
use App\Models\Website;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WebsiteVisitorsStatsWidget extends BaseWidget
{
    protected static bool $isLazy = true;

    public ?Website $record = null;

    public function getStats(): array
    {
        $visitorCount = Visitor::where('visitable_type', Website::class)
            ->where('visitable_id', $this->record->id)
            ->count();

        return [
            Stat::make(__('admin.website_visitors'), $visitorCount)
                ->description(__('admin.visitor_count'))
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
        ];
    }
}
