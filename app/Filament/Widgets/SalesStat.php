<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use App\Models\Sales;


class SalesStat extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $userId = Auth::user()->hasRole('saler') ? Auth::user()->id : null;

        // Today's Sales
        $todaysSales = $this->getSalesCount($userId, 'today');
        $yesterdaySales = $this->getSalesCount($userId, 'yesterday');

        // Weekly Sales (current week vs last week)
        $weeklySales = $this->getSalesCount($userId, 'week');
        $lastWeekSales = $this->getSalesCount($userId, 'lastWeek');

        // Monthly Sales (current month vs last month)
        $monthlySales = $this->getSalesCount($userId, 'month');
        $lastMonthSales = $this->getSalesCount($userId, 'lastMonth');

        // Calculate percentage changes
        $dailyChange = $this->calculatePercentageChange($todaysSales, $yesterdaySales);
        $weeklyChange = $this->calculatePercentageChange($weeklySales, $lastWeekSales);
        $monthlyChange = $this->calculatePercentageChange($monthlySales, $lastMonthSales);

        return [
            Stat::make('Today\'s Sales', $todaysSales)
                ->description($this->getChangeDescription($dailyChange, 'vs yesterday'))
                ->descriptionIcon($this->getChangeIcon($dailyChange))
                ->color($this->getChangeColor($dailyChange)),

            Stat::make('Weekly Sales', $weeklySales)
                ->description($this->getChangeDescription($weeklyChange, 'vs last week'))
                ->descriptionIcon($this->getChangeIcon($weeklyChange))
                ->color($this->getChangeColor($weeklyChange)),

            Stat::make('Monthly Sales', $monthlySales)
                ->description($this->getChangeDescription($monthlyChange, 'vs last month'))
                ->descriptionIcon($this->getChangeIcon($monthlyChange))
                ->color($this->getChangeColor($monthlyChange)),
        ];
    }

    /**
     * Get sales count for a specific period
     */
    protected function getSalesCount(?int $userId, string $period): int
    {
        $query = Sales::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return match ($period) {
            'today' => $query->whereDate('created_at', today())->count(),
            'yesterday' => $query->whereDate('created_at', today()->subDay())->count(),
            'week' => $query->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'lastWeek' => $query->whereBetween('created_at', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek()
            ])->count(),
            'month' => $query->whereMonth('created_at', today()->month())
                ->whereYear('created_at', today()->year())
                ->count(),
            'lastMonth' => $query->whereMonth('created_at', today()->subMonth()->month())
                ->whereYear('created_at', today()->subMonth()->year())
                ->count(),
            default => 0,
        };
    }

    /**
     * Calculate percentage change between current and previous values
     */
    protected function calculatePercentageChange(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    /**
     * Get description text for the change
     */
    protected function getChangeDescription(float $change, string $comparison): string
    {
        $absChange = abs(round($change, 1));

        if ($change > 0) {
            return "{$absChange}% increase {$comparison}";
        } elseif ($change < 0) {
            return "{$absChange}% decrease {$comparison}";
        }

        return "No change {$comparison}";
    }

    /**
     * Get icon based on change direction
     */
    protected function getChangeIcon(float $change): string
    {
        if ($change > 0) {
            return 'heroicon-m-arrow-trending-up';
        } elseif ($change < 0) {
            return 'heroicon-m-arrow-trending-down';
        }

        return 'heroicon-m-minus';
    }

    /**
     * Get color based on change direction
     */
    protected function getChangeColor(float $change): string
    {
        if ($change > 0) {
            return 'success';
        } elseif ($change < 0) {
            return 'danger';
        }

        return 'gray';
    }
}
