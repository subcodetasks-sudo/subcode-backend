<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Order;
use App\Models\Course;
use App\Models\Visitor;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class AOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('strings.visitors'), Visitor::count()),

        ];
    }   
}
