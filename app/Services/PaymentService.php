<?php

namespace App\Services;

use App\Contracts\PaymentRequest;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(
        protected PaymentProcessorRegistry $processorRegistry
    ) {}
    public function processSubscriptionPayment(UserSubscription $subscription): bool
    {
        return DB::transaction(function () use ($subscription) {
            $user = $subscription->user;
            $paymentMethods = $this->getPaymentMethodsWithFallback($user);

            if ($paymentMethods->isEmpty()) {
                Log::warning("No payment methods available for user {$user->id}");
                return false;
            }

            $invoice = $this->createInvoiceForSubscription($subscription);

            foreach ($paymentMethods as $paymentMethod) {
                try {
                    $response = $this->processPaymentWithProcessor($invoice, $paymentMethod);
                    
                    if ($response->isSuccessful()) {
                        $invoice->update([
                            'payment_method_id' => $paymentMethod->id,
                            'status' => 'paid',
                            'paid_at' => now(),
                            'payment_data' => $response->toArray(),
                        ]);
                        
                        $paymentMethod->markAsUsed();
                        
                        Log::info("Payment successful for subscription {$subscription->id} using payment method {$paymentMethod->id}");
                        return true;
                    } else {
                        Log::warning("Payment failed for subscription {$subscription->id} using payment method {$paymentMethod->id}: " . $response->errorMessage);
                        $this->disableFailedPaymentMethod($paymentMethod, $response->errorMessage ?? 'Unknown error');
                    }
                } catch (\Exception $e) {
                    Log::warning("Payment failed for subscription {$subscription->id} using payment method {$paymentMethod->id}: " . $e->getMessage());
                    
                    $this->disableFailedPaymentMethod($paymentMethod, $e->getMessage());
                    continue;
                }
            }

            $invoice->markAsFailed();
            Log::error("All payment methods failed for subscription {$subscription->id}");
            
            return false;
        });
    }

    public function processInvoicePayment(Invoice $invoice, ?PaymentMethod $specificPaymentMethod = null): bool
    {
        return DB::transaction(function () use ($invoice, $specificPaymentMethod) {
            if ($specificPaymentMethod) {
                $paymentMethods = collect([$specificPaymentMethod]);
            } else {
                $paymentMethods = $this->getPaymentMethodsWithFallback($invoice->user);
            }

            foreach ($paymentMethods as $paymentMethod) {
                try {
                    $response = $this->processPaymentWithProcessor($invoice, $paymentMethod);
                    
                    if ($response->isSuccessful()) {
                        $invoice->update([
                            'payment_method_id' => $paymentMethod->id,
                            'status' => 'paid',
                            'paid_at' => now(),
                            'payment_data' => $response->toArray(),
                        ]);
                        
                        $paymentMethod->markAsUsed();
                        return true;
                    } else {
                        $this->disableFailedPaymentMethod($paymentMethod, $response->errorMessage ?? 'Unknown error');
                    }
                } catch (\Exception $e) {
                    $this->disableFailedPaymentMethod($paymentMethod, $e->getMessage());
                    continue;
                }
            }

            $invoice->markAsFailed();
            return false;
        });
    }

    protected function getPaymentMethodsWithFallback(User $user)
    {
        return $user->paymentMethods()
            ->active()
            ->byPriority()
            ->get();
    }

    protected function processPaymentWithProcessor(Invoice $invoice, PaymentMethod $paymentMethod)
    {
        Log::info("Processing payment for invoice {$invoice->id} with payment method {$paymentMethod->id} ({$paymentMethod->type->value})");

        // Get processor by provider (if specified) or by payment method type
        if ($paymentMethod->provider) {
            $processor = $this->processorRegistry->getProcessorForProvider($paymentMethod->provider);
        } else {
            $processor = $this->processorRegistry->getProcessorForPaymentMethodType($paymentMethod->type);
        }

        $paymentRequest = new PaymentRequest(
            invoice: $invoice,
            paymentMethod: $paymentMethod,
            amount: (float) $invoice->total_amount,
            currency: $invoice->currency,
            metadata: [
                'user_id' => $invoice->user_id,
                'subscription_id' => $invoice->user_subscription_id,
            ]
        );

        return $processor->processPayment($paymentRequest);
    }

    public function createPaymentMethod(User $user, string $processorName, array $data): array
    {
        $processor = $this->processorRegistry->get($processorName);
        $response = $processor->createPaymentMethod($data);

        if ($response->isSuccessful()) {
            $paymentMethod = PaymentMethod::create([
                'user_id' => $user->id,
                'type' => $data['type'],
                'name' => $data['name'] ?? "{$processorName} Payment Method",
                'provider' => $processorName,
                'provider_payment_method_id' => $response->paymentMethodId,
                'metadata' => $response->metadata,
                'priority' => $data['priority'] ?? 0,
                'is_enabled' => true,
                'is_default' => $data['is_default'] ?? false,
                'verified_at' => $response->requiresVerification ? null : now(),
            ]);

            return [
                'success' => true,
                'payment_method' => $paymentMethod,
                'setup_url' => $response->setupUrl,
                'requires_verification' => $response->requiresVerification,
            ];
        }

        return [
            'success' => false,
            'error' => $response->errorMessage,
        ];
    }

    protected function disableFailedPaymentMethod(PaymentMethod $paymentMethod, string $errorMessage): void
    {
        $failureCount = $paymentMethod->metadata['failure_count'] ?? 0;
        $failureCount++;

        $metadata = $paymentMethod->metadata ?? [];
        $metadata['failure_count'] = $failureCount;
        $metadata['last_failure'] = [
            'message' => $errorMessage,
            'timestamp' => now()->toISOString(),
        ];

        if ($failureCount >= 3) {
            $paymentMethod->update([
                'is_enabled' => false,
                'metadata' => $metadata,
            ]);
            
            Log::warning("Payment method {$paymentMethod->id} disabled after {$failureCount} failures");
        } else {
            $paymentMethod->update(['metadata' => $metadata]);
        }
    }

    protected function createInvoiceForSubscription(UserSubscription $subscription): Invoice
    {
        return Invoice::create([
            'user_id' => $subscription->user_id,
            'user_subscription_id' => $subscription->id,
            'amount' => $subscription->price_paid,
            'tax_amount' => 0,
            'total_amount' => $subscription->price_paid,
            'currency' => 'USD',
            'status' => 'pending',
            'description' => "Payment for {$subscription->subscriptionPackage->name} subscription",
            'line_items' => [
                [
                    'description' => $subscription->subscriptionPackage->name,
                    'quantity' => 1,
                    'amount' => $subscription->price_paid,
                ]
            ],
            'due_date' => now()->addDays(7),
        ]);
    }
}