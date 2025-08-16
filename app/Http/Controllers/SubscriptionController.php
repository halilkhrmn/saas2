<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\SubscriptionPackage;
use App\Models\UserSubscription;
use App\Services\InvoiceService;
use App\Services\EmailNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct(
        protected InvoiceService $invoiceService,
        protected EmailNotificationService $emailService
    ) {}

    public function buy(Request $request, string $packageSlug)
    {
        $package = SubscriptionPackage::where('slug', $packageSlug)
                                    ->where('is_active', true)
                                    ->firstOrFail();

        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;
        
        // Eğer aktif subscription varsa, sadece upgrade'e izin ver
        if ($activeSubscription) {
            $currentPackage = $activeSubscription->subscriptionPackage;
            
            // Aynı paketi tekrar almaya çalışıyorsa engelle
            if ($currentPackage->id === $package->id) {
                return redirect()->route('dashboard')
                    ->with('info', 'You already have this plan active.');
            }
            
            // Package change kontrolü
            $changeType = $package->getChangeTypeFrom($currentPackage);
            
            if ($changeType === 'unavailable') {
                return redirect()->route('dashboard')
                    ->with('error', 'This package change is not available.');
            }
            
            // Downgrade'e izin verme (şimdilik)
            if ($changeType === 'downgrade') {
                return redirect()->route('dashboard')
                    ->with('error', 'To downgrade your plan, please contact support.');
            }
            
            // Bu bir upgrade işlemi
            $isUpgrade = true;
        } else {
            $isUpgrade = false;
        }

        $billingCycle = $request->get('cycle', 'monthly');
        
        if (!in_array($billingCycle, ['monthly', 'yearly'])) {
            $billingCycle = 'monthly';
        }

        $price = $billingCycle === 'yearly' ? $package->yearly_price : $package->monthly_price;

        return view('subscription.buy', compact('package', 'billingCycle', 'price', 'isUpgrade', 'activeSubscription'));
    }

    public function purchase(Request $request, string $packageSlug)
    {
        $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $package = SubscriptionPackage::where('slug', $packageSlug)
                                    ->where('is_active', true)
                                    ->firstOrFail();

        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;
        $billingCycle = $request->billing_cycle;
        
        // Aktif subscription kontrolü
        if ($activeSubscription) {
            $currentPackage = $activeSubscription->subscriptionPackage;
            
            // Aynı paketi tekrar almaya çalışıyorsa engelle
            if ($currentPackage->id === $package->id) {
                return redirect()->route('dashboard')
                    ->with('info', 'You already have this plan active.');
            }
            
            // Package change kontrolü
            $changeType = $package->getChangeTypeFrom($currentPackage);
            
            if ($changeType === 'unavailable') {
                return redirect()->route('dashboard')
                    ->with('error', 'This package change is not available.');
            }
            
            // Downgrade'e izin verme (şimdilik)
            if ($changeType === 'downgrade') {
                return redirect()->route('dashboard')
                    ->with('error', 'To downgrade your plan, please contact support.');
            }
            
            // Mevcut subscription'ı sonlandır
            $activeSubscription->update([
                'status' => 'cancelled',
                'ends_at' => now()
            ]);
        }
        
        $price = $billingCycle === 'yearly' ? $package->yearly_price : $package->monthly_price;

        if ($price == 0) {
            $subscription = $this->createSubscription($user, $package, $billingCycle, $price);
            
            // Eğer API key yoksa oluştur
            if (!$user->apiKeys()->exists()) {
                $user->apiKeys()->create([
                    'name' => 'Default API Key',
                    'key' => 'sk_' . str()->random(40),
                    'is_active' => true
                ]);
            }

            $message = $activeSubscription ? 'Plan upgraded successfully!' : 'Welcome! Your free plan is now active.';
            return redirect()->route('dashboard')->with('success', $message);
        }

        $subscription = $this->createSubscription($user, $package, $billingCycle, $price);

        $invoice = $this->invoiceService->createInvoiceForSubscription($subscription);

        // Send invoice created notification
        $this->emailService->sendInvoiceCreated($invoice);

        return redirect()->route('subscription.invoice', $invoice);
    }

    public function invoice(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        return view('subscription.invoice', compact('invoice'));
    }

    public function pay(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }

        if ($invoice->isPaid()) {
            return redirect()->route('dashboard')->with('info', 'This invoice has already been paid.');
        }

        $invoice->markAsPaid();

        if ($invoice->userSubscription) {
            $invoice->userSubscription->update(['status' => 'active']);
            
            // Eğer API key yoksa oluştur
            $user = Auth::user();
            if (!$user->apiKeys()->exists()) {
                $user->apiKeys()->create([
                    'name' => 'Default API Key',
                    'key' => 'sk_' . str()->random(40),
                    'is_active' => true
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Payment successful! Your subscription is now active.');
    }

    protected function createSubscription($user, $package, $billingCycle, $price): UserSubscription
    {
        $startsAt = now();
        $endsAt = $billingCycle === 'yearly' 
                    ? $startsAt->copy()->addYear() 
                    : $startsAt->copy()->addMonth();

        $status = $price == 0 ? 'active' : 'pending';

        return $user->userSubscriptions()->create([
            'subscription_package_id' => $package->id,
            'billing_cycle' => $billingCycle,
            'status' => $status,
            'price_paid' => $price,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ]);
    }
    
}
