<?php
namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Order;
use App\Models\Project;
use App\Models\Publication;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Clients', Client::count())
                ->description('Registered clients')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Active Projects', Project::where('status', 'in_progress')->count())
                ->description('Total: ' . Project::count() . ' projects')
                ->descriptionIcon('heroicon-o-folder')
                ->color('warning'),

            Stat::make('Pending Orders', Order::where('status', 'pending')->count())
                ->description('Total: ' . Order::count() . ' orders')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('danger'),

            Stat::make('Publications', Publication::where('is_published', true)->count())
                ->description('Published articles')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('success'),
        ];
    }
}
