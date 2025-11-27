<?php

namespace App\Filament\Widgets;

use App\Models\Sales;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
class SalerStat extends StatsOverviewWidget
{
    // protected static ?string $heading = 'Saler Stat';

protected static ?int $sort = 3;




    protected function getStats(): array
    {
        $stats = [];
        
        // Get all users who have made sales
        $salespeople = \App\Models\User::query()
            ->whereHas('sales')
            ->with(['sales' => function ($query) {
                $query->select('user_id', 'sale_date', 'id');
            }])
            ->get();

        foreach ($salespeople as $salesperson) {
            // Count sales for today
            $todayCount = \App\Models\Sales::query()
                ->where('user_id', $salesperson->id)
                ->whereDate('sale_date', today())
                ->count();

            // Count sales for this week
            $weekCount = \App\Models\Sales::query()
                ->where('user_id', $salesperson->id)
                ->whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();

            // Count sales for this month
            $monthCount = \App\Models\Sales::query()
                ->where('user_id', $salesperson->id)
                ->whereMonth('sale_date', now()->month)
                ->whereYear('sale_date', now()->year)
                ->count();

            // Create stat card for this salesperson
            $stats[] = Stat::make($salesperson->name, $monthCount . ' sales this month')
                ->description("Today: {$todayCount} | This Week: {$weekCount}")
                ->descriptionIcon('heroicon-m-user-circle')
                ->color($monthCount > 0 ? 'success' : 'gray')
                ->chart($this->getSalesChartData($salesperson->id));
        }

        // If no salespeople found, show a placeholder
        if (empty($stats)) {
            $stats[] = Stat::make('No Sales Data', 'No sales recorded yet')
                ->description('Start recording sales to see statistics')
                ->descriptionIcon('heroicon-m-information-circle')
                ->color('gray');
        }

        return $stats;
    }

    /**
     * Get sales chart data for the last 7 days for a specific salesperson
     */
    protected function getSalesChartData(int $userId): array
    {
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $count = \App\Models\Sales::query()
                ->where('user_id', $userId)
                ->whereDate('sale_date', $date)
                ->count();
            $data[] = $count;
        }
        
        return $data;
    }
}
