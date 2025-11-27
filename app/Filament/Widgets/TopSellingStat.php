<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TopSellingStat extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    
    protected function getStats(): array
    {
        // Get top selling product today
        $topToday = \App\Models\Sales::query()
            ->whereDate('sale_date', today())
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->first();

        // Get top selling product this week
        $topWeek = \App\Models\Sales::query()
            ->whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->first();

        // Get top selling product this month
        $topMonth = \App\Models\Sales::query()
            ->whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->with('product')
            ->first();

        return [
            Stat::make('Top Selling Today', $topToday ? $topToday->product->name : 'No sales')
                ->description($topToday ? "Quantity: {$topToday->total_quantity}" : 'No data available')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color($topToday ? 'success' : 'gray'),
            
            Stat::make('Top Selling This Week', $topWeek ? $topWeek->product->name : 'No sales')
                ->description($topWeek ? "Quantity: {$topWeek->total_quantity}" : 'No data available')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color($topWeek ? 'success' : 'gray'),
            
            Stat::make('Top Selling This Month', $topMonth ? $topMonth->product->name : 'No sales')
                ->description($topMonth ? "Quantity: {$topMonth->total_quantity}" : 'No data available')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color($topMonth ? 'success' : 'gray'),
        ];
    }
}
