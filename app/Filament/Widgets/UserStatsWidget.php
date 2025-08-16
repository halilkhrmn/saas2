<?php

namespace App\Filament\Widgets;

use App\Models\ApiKey;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UserSubscription;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Total users (excluding admin)
        $totalUsers = User::where('email', '!=', 'admin@example.com')->count();
        
        // New users this month
        $newUsersThisMonth = User::where('email', '!=', 'admin@example.com')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Users with active subscriptions
        $subscribedUsers = User::where('email', '!=', 'admin@example.com')
            ->whereHas('userSubscriptions', function ($query) {
                $query->where('status', 'active');
            })
            ->count();

        // Conversion rate
        $conversionRate = $totalUsers > 0 ? ($subscribedUsers / $totalUsers) * 100 : 0;

        // Pending invoices that need attention
        $pendingInvoices = Invoice::where('status', 'pending')
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->count();

        // Overdue invoices
        $overdueInvoices = Invoice::where('status', 'pending')
            ->where('due_date', '<', now())
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->count();

        // Active API keys
        $activeApiKeys = ApiKey::where('is_active', true)
            ->whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->count();

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description($newUsersThisMonth . ' new this month')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Subscribed Users', number_format($subscribedUsers))
                ->description(number_format($conversionRate, 1) . '% conversion rate')
                ->descriptionIcon('heroicon-m-star')
                ->color('success'),

            Stat::make('Pending Invoices', number_format($pendingInvoices))
                ->description($overdueInvoices . ' overdue')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($overdueInvoices > 0 ? 'danger' : 'warning'),

            Stat::make('Active API Keys', number_format($activeApiKeys))
                ->description('Currently in use')
                ->descriptionIcon('heroicon-m-key')
                ->color('info'),
        ];
    }
}
