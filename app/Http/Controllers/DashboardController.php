<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;
        $apiKeys = $user->apiKeys()->latest()->get();
        $recentInvoices = $user->invoices()->latest()->limit(5)->get();

        $stats = [
            'total_api_calls' => $activeSubscription ? $activeSubscription->api_calls_used : 0,
            'remaining_api_calls' => $activeSubscription ? $activeSubscription->remaining_api_calls : 0,
            'api_calls_limit' => $activeSubscription ? $activeSubscription->subscriptionPackage->api_calls_limit : 0,
            'active_api_keys' => $user->apiKeys()->active()->count(),
        ];

        return view('dashboard.index', compact('user', 'activeSubscription', 'apiKeys', 'recentInvoices', 'stats'));
    }

    public function invoices()
    {
        $user = Auth::user();
        $invoices = $user->invoices()->latest()->paginate(20);

        return view('dashboard.invoices', compact('user', 'invoices'));
    }
}
