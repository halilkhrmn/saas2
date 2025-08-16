<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\UserSubscription;
use App\Services\EmailNotificationService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SubscriptionMonitoringService
{
    public function __construct(
        protected EmailNotificationService $emailService
    ) {}

    public function checkExpiringSubscriptions(): Collection
    {
        if (!config('notifications.enabled')) {
            return collect();
        }

        $warningDays = config('notifications.subscriptions.expiry_warning_days', 7);
        $warningDate = now()->addDays($warningDays);

        $expiringSubscriptions = UserSubscription::where('status', 'active')
            ->where('ends_at', '<=', $warningDate)
            ->where('ends_at', '>', now())
            ->with(['user', 'subscriptionPackage'])
            ->get();

        foreach ($expiringSubscriptions as $subscription) {
            $this->emailService->sendSubscriptionExpiryWarning($subscription);
            
            Log::info('Subscription expiry warning sent', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'expires_at' => $subscription->ends_at,
            ]);
        }

        return $expiringSubscriptions;
    }

    public function checkOverdueInvoices(): Collection
    {
        if (!config('notifications.enabled')) {
            return collect();
        }

        $overdueInvoices = Invoice::where('status', 'pending')
            ->where('due_date', '<', now())
            ->with(['user', 'userSubscription.subscriptionPackage'])
            ->get();

        foreach ($overdueInvoices as $invoice) {
            $this->emailService->sendOverdueInvoiceReminder($invoice);
            
            Log::info('Overdue invoice reminder sent', [
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user_id,
                'due_date' => $invoice->due_date,
            ]);
        }

        return $overdueInvoices;
    }

    public function checkUpcomingInvoices(): Collection
    {
        if (!config('notifications.enabled')) {
            return collect();
        }

        $reminderDays = config('notifications.invoices.payment_reminder_days', 3);
        $reminderDate = now()->addDays($reminderDays);

        $upcomingInvoices = Invoice::where('status', 'pending')
            ->where('due_date', '<=', $reminderDate)
            ->where('due_date', '>', now())
            ->with(['user', 'userSubscription.subscriptionPackage'])
            ->get();

        foreach ($upcomingInvoices as $invoice) {
            $this->emailService->sendPaymentReminder($invoice);
            
            Log::info('Payment reminder sent', [
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user_id,
                'due_date' => $invoice->due_date,
            ]);
        }

        return $upcomingInvoices;
    }

    public function expireSubscriptions(): Collection
    {
        $expiredSubscriptions = UserSubscription::where('status', 'active')
            ->where('ends_at', '<=', now())
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['status' => 'expired']);
            
            $subscription->user->apiKeys()->update(['is_active' => false]);
            
            $this->emailService->sendSubscriptionExpiredNotification($subscription);
            
            Log::info('Subscription expired', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'expired_at' => $subscription->ends_at,
            ]);
        }

        return $expiredSubscriptions;
    }

    public function generateRenewalInvoices(): Collection
    {
        $renewingSubscriptions = UserSubscription::where('status', 'active')
            ->where('ends_at', '<=', now()->addDays(1))
            ->where('ends_at', '>', now())
            ->whereHas('subscriptionPackage', function ($query) {
                $query->where('monthly_price', '>', 0)
                      ->orWhere('yearly_price', '>', 0);
            })
            ->with(['user', 'subscriptionPackage'])
            ->get();

        $generatedInvoices = collect();

        foreach ($renewingSubscriptions as $subscription) {
            $invoice = app(InvoiceService::class)->createRenewalInvoice($subscription);
            
            $this->emailService->sendInvoiceCreated($invoice);
            
            $generatedInvoices->push($invoice);
            
            Log::info('Renewal invoice generated', [
                'subscription_id' => $subscription->id,
                'invoice_id' => $invoice->id,
                'user_id' => $subscription->user_id,
            ]);
        }

        return $generatedInvoices;
    }

    public function sendPaymentReminders(): Collection
    {
        return $this->checkUpcomingInvoices();
    }

    public function processExpiredSubscriptions(): int
    {
        return $this->expireSubscriptions()->count();
    }

    public function runDailyChecks(): array
    {
        return [
            'expiring_subscriptions' => $this->checkExpiringSubscriptions(),
            'overdue_invoices' => $this->checkOverdueInvoices(),
            'upcoming_invoices' => $this->checkUpcomingInvoices(),
            'expired_subscriptions' => $this->expireSubscriptions(),
            'renewal_invoices' => $this->generateRenewalInvoices(),
        ];
    }
}
