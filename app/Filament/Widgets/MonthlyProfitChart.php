<?php

namespace App\Filament\Widgets;

use App\Models\Visitor;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\App;
use App\Enum\VisitorTypeEnum;
class MonthlyProfitChart extends ChartWidget
{
    public function getHeading(): string
    {
        return __('strings.visitors_statistics');
    }

    public function getlabel(): string
    {
        return __('strings.visitors_statistics');
    }

    protected function getData(): array
    {
        $now = Carbon::now();

        $weeklyData = collect(range(0, 6))->map(function ($day) use ($now) {
            $date = $now->copy()->startOfWeek(Carbon::MONDAY)->addDays($day);

            return Visitor::whereDate('created_at', $date)->where('type', VisitorTypeEnum::SITE->value)->count();
        });

        $daysInMonth = $now->daysInMonth;
        $monthlyData = collect(range(1, $daysInMonth))->map(function ($day) use ($now) {
            $date = $now->copy()->startOfMonth()->addDays($day - 1);

            return Visitor::whereDate('created_at', $date)->where('type', VisitorTypeEnum::SITE->value)->count();
        });

        $yearlyData = collect(range(1, 12))->map(function ($month) use ($now) {
            return Visitor::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $month)
                ->where('type', VisitorTypeEnum::SITE->value)
                ->count();
        });

        $locale = App::getLocale();
        $weekDays = $locale === 'ar'
            ? ['الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت', 'الأحد']
            : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        $months = $locale === 'ar'
            ? ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر']
            : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        return [
            'datasets' => [
                [
                    'label' => __('strings.this_week'),
                    'data' => $weeklyData,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.3)',
                ],
                [
                    'label' => __('strings.this_month'),
                    'data' => $monthlyData,
                    'borderColor' => 'rgba(153, 102, 255, 1)',
                    'backgroundColor' => 'rgba(153, 102, 255, 0.3)',
                ],
                [
                    'label' => __('strings.this_year'),
                    'data' => $yearlyData,
                    'borderColor' => 'rgba(255, 159, 64, 1)',
                    'backgroundColor' => 'rgba(255, 159, 64, 0.3)',
                ],
            ],
            'labels' => $weekDays,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
