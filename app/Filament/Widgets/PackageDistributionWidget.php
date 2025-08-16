<?php

namespace App\Filament\Widgets;

use App\Models\UserSubscription;
use Filament\Widgets\ChartWidget;

class PackageDistributionWidget extends ChartWidget
{
    protected static ?int $sort = 5;
    
    public function getHeading(): string
    {
        return 'Popular Subscription Packages';
    }
    
    public function getMaxHeight(): ?string
    {
        return '300px';
    }

    protected function getData(): array
    {
        $packageCounts = UserSubscription::whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->where('status', 'active')
            ->with('subscriptionPackage')
            ->get()
            ->groupBy('subscriptionPackage.name')
            ->map(function ($subscriptions) {
                return $subscriptions->count();
            });

        $labels = $packageCounts->keys()->toArray();
        $data = $packageCounts->values()->toArray();
        
        $colors = [
            'rgb(59, 130, 246)',   // Blue
            'rgb(16, 185, 129)',   // Green
            'rgb(245, 101, 101)',  // Red
            'rgb(251, 191, 36)',   // Yellow
            'rgb(139, 92, 246)',   // Purple
        ];

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'borderColor' => array_slice($colors, 0, count($data)),
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { 
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ": " + context.parsed + " subscribers (" + percentage + "%)";
                        }',
                    ],
                ],
            ],
        ];
    }
}