<?php

namespace App\Filament\Widgets;

use App\Models\ApiKey;
use App\Models\UserSubscription;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApiUsageWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 7;

    protected function getStats(): array
    {
        // Total API calls made across all users
        $totalApiCalls = UserSubscription::whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->sum('api_calls_used');

        // API calls this month
        $thisMonthApiCalls = UserSubscription::whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->where('status', 'active')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('api_calls_used');

        // Average API calls per user
        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->count();

        $avgApiCallsPerUser = $activeSubscriptions > 0 
            ? $totalApiCalls / $activeSubscriptions 
            : 0;

        // Top usage subscription
        $topUsageSubscription = UserSubscription::whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->where('status', 'active')
            ->orderBy('api_calls_used', 'desc')
            ->first();

        $topUsage = $topUsageSubscription ? $topUsageSubscription->api_calls_used : 0;

        // Active API keys count
        $activeApiKeys = ApiKey::where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->count();

        return [
            Stat::make('Total API Calls', number_format($totalApiCalls))
                ->description('All time usage')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),

            Stat::make('Active API Keys', number_format($activeApiKeys))
                ->description('Currently active')
                ->descriptionIcon('heroicon-m-key')
                ->color('success'),

            Stat::make('Average Usage/User', number_format($avgApiCallsPerUser, 0))
                ->description('API calls per user')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),

            Stat::make('Highest Usage', number_format($topUsage))
                ->description('Single user maximum')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
        ];
    }
}