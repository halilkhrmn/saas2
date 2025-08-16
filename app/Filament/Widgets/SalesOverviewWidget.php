<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Total revenue from paid invoices
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        
        // Revenue this month
        $thisMonthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
            
        // Revenue last month for comparison
        $lastMonthRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');
            
        $monthlyGrowth = $lastMonthRevenue > 0 
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // Active subscriptions
        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->count();

        // Monthly recurring revenue (MRR)
        $monthlyMRR = UserSubscription::where('status', 'active')
            ->where('billing_cycle', 'monthly')
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->sum('price_paid');
            
        $yearlyARR = UserSubscription::where('status', 'active')
            ->where('billing_cycle', 'yearly')
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->sum('price_paid');

        $totalMRR = $monthlyMRR + ($yearlyARR / 12);

        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('All time revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Monthly Revenue', '$' . number_format($thisMonthRevenue, 2))
                ->description(($monthlyGrowth >= 0 ? '+' : '') . number_format($monthlyGrowth, 1) . '% from last month')
                ->descriptionIcon($monthlyGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthlyGrowth >= 0 ? 'success' : 'danger'),

            Stat::make('Active Subscriptions', number_format($activeSubscriptions))
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Monthly Recurring Revenue', '$' . number_format($totalMRR, 2))
                ->description('MRR + ARR/12')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
        ];
    }
}
