<?php
namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('client_name')->label('Client'),
                Tables\Columns\TextColumn::make('domain'),
                Tables\Columns\TextColumn::make('price_estimate')->money('USD')->label('Estimate'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'contacted' => 'info',
                        'accepted'  => 'success',
                        'rejected'  => 'danger',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->since()->label('Date'),
            ]);
    }
}
