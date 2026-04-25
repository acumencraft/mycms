<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Purchase;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueWidget extends ChartWidget
{
    protected static ?int $sort = 4;
    protected ?string $heading = 'Revenue (Last 6 Months)';
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i));

        $orders = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(price_estimate) as total")
            ->where('status', 'accepted')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('total', 'month');

        $purchases = Purchase::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total")
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('total', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'Orders Revenue',
                    'data' => $months->map(fn($m) => $orders[$m->format('Y-m')] ?? 0)->values()->toArray(),
                    'backgroundColor' => 'rgba(245,158,11,0.8)',
                ],
                [
                    'label' => 'Shop Revenue',
                    'data' => $months->map(fn($m) => $purchases[$m->format('Y-m')] ?? 0)->values()->toArray(),
                    'backgroundColor' => 'rgba(16,185,129,0.8)',
                ],
            ],
            'labels' => $months->map(fn($m) => $m->format('M Y'))->values()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
