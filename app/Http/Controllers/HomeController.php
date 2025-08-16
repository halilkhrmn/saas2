<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $packages = SubscriptionPackage::active()->ordered()->get();
        $activeSubscription = Auth::check() ? Auth::user()->activeSubscription : null;
        $currentPackage = $activeSubscription ? $activeSubscription->subscriptionPackage : null;

        return view('pricing', compact('packages', 'activeSubscription', 'currentPackage'));
    }
}