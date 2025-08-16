<?php

namespace App\Filament\Widgets;

use App\Models\UserSubscription;
use Filament\Widgets\ChartWidget;

class SubscriptionStatusWidget extends ChartWidget
{
    protected static ?int $sort = 4;
    
    public function getHeading(): string
    {
        return 'Subscription Status Distribution';
    }
    
    public function getMaxHeight(): ?string
    {
        return '300px';
    }

    protected function getData(): array
    {
        $statusCounts = UserSubscription::whereHas('user', function ($query) {
                $query->where('email', '!=', 'admin@example.com');
            })
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $labels = [];
        $data = [];
        $colors = [];

        $statusColors = [
            'active' => 'rgb(34, 197, 94)',
            'pending' => 'rgb(251, 191, 36)',
            'cancelled' => 'rgb(239, 68, 68)',
            'expired' => 'rgb(156, 163, 175)',
        ];

        $statusLabels = [
            'active' => 'Active',
            'pending' => 'Pending',
            'cancelled' => 'Cancelled',
            'expired' => 'Expired',
        ];

        foreach ($statusCounts as $status => $count) {
            $labels[] = $statusLabels[$status] ?? ucfirst($status);
            $data[] = $count;
            $colors[] = $statusColors[$status] ?? 'rgb(99, 102, 241)';
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
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
                            return context.label + ": " + context.parsed + " (" + percentage + "%)";
                        }',
                    ],
                ],
            ],
        ];
    }
}
