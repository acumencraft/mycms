<?php
namespace App\Filament\Widgets;

use App\Models\Visit;
use App\Models\Order;
use App\Models\Purchase;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class AnalyticsWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Visits (Last 30 Days)';
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(fn($i) => Carbon::now()->subDays($i)->format('Y-m-d'));

        $visits = Visit::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->pluck('count', 'date');

        return [
            'datasets' => [
                [
                    'label' => 'Visits',
                    'data' => $days->map(fn($d) => $visits[$d] ?? 0)->values()->toArray(),
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245,158,11,0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $days->map(fn($d) => Carbon::parse($d)->format('M d'))->values()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
