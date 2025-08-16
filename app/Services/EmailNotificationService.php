<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\User;
use App\Models\UserSubscription;
use App\Mail\InvoiceCreated;
use App\Mail\OverdueInvoiceReminder;
use App\Mail\PaymentReminder;
use App\Mail\SubscriptionExpiredNotification;
use App\Mail\SubscriptionExpiryWarning;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService
{
    public function sendWelcomeEmail(User $user): bool
    {
        if (!config('notifications.emails.welcome')) {
            return false;
        }

        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send welcome email', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendInvoiceCreated(Invoice $invoice): bool
    {
        if (!config('notifications.emails.invoice')) {
            return false;
        }

        try {
            Mail::to($invoice->user->email)->send(new InvoiceCreated($invoice));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice created email', [
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user_id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendPaymentReminder(Invoice $invoice): bool
    {
        if (!config('notifications.emails.payment_reminder')) {
            return false;
        }

        try {
            Mail::to($invoice->user->email)->send(new PaymentReminder($invoice));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send payment reminder email', [
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user_id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendOverdueInvoiceReminder(Invoice $invoice): bool
    {
        if (!config('notifications.emails.payment_reminder')) {
            return false;
        }

        try {
            Mail::to($invoice->user->email)->send(new OverdueInvoiceReminder($invoice));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send overdue invoice reminder email', [
                'invoice_id' => $invoice->id,
                'user_id' => $invoice->user_id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendSubscriptionExpiryWarning(UserSubscription $subscription): bool
    {
        if (!config('notifications.enabled')) {
            return false;
        }

        try {
            Mail::to($subscription->user->email)->send(new SubscriptionExpiryWarning($subscription));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send subscription expiry warning email', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendSubscriptionExpiredNotification(UserSubscription $subscription): bool
    {
        if (!config('notifications.enabled')) {
            return false;
        }

        try {
            Mail::to($subscription->user->email)->send(new SubscriptionExpiredNotification($subscription));
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send subscription expired notification email', [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
