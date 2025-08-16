<?php

namespace App\Http\Controllers;

use App\PaymentMethodType;
use App\Services\PaymentProcessorRegistry;
use App\Services\PaymentService;
use App\Services\SubscriptionChangeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected PaymentProcessorRegistry $processorRegistry,
        protected SubscriptionChangeService $subscriptionChangeService
    ) {}

    public function getAvailableProcessors()
    {
        return response()->json([
            'processors' => $this->processorRegistry->getProcessorCapabilities(),
            'supported_types' => $this->processorRegistry->getAllSupportedTypes()
                ->map(fn($type) => [
                    'value' => $type->value,
                    'label' => $type->label(),
                    'description' => $type->description(),
                ]),
        ]);
    }

    public function createPaymentMethod(Request $request)
    {
        $request->validate([
            'processor' => 'required|string',
            'type' => 'required|string',
            'name' => 'required|string',
            'data' => 'required|array',
        ]);

        $user = Auth::user();
        $processor = $request->input('processor');
        $type = PaymentMethodType::from($request->input('type'));

        // Verify processor supports this type
        $supportedTypes = $this->processorRegistry->getSupportedTypesForProcessor($processor);
        if (!in_array($type, $supportedTypes)) {
            return response()->json([
                'error' => "Processor {$processor} does not support {$type->value} payments"
            ], 400);
        }

        $data = array_merge($request->input('data'), [
            'type' => $type,
            'name' => $request->input('name'),
        ]);

        $result = $this->paymentService->createPaymentMethod($user, $processor, $data);

        if ($result['success']) {
            return response()->json([
                'payment_method' => $result['payment_method'],
                'setup_url' => $result['setup_url'] ?? null,
                'requires_verification' => $result['requires_verification'] ?? false,
            ], 201);
        }

        return response()->json(['error' => $result['error']], 400);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
        ]);

        $user = Auth::user();
        $invoice = $user->invoices()->findOrFail($request->input('invoice_id'));
        
        $paymentMethod = null;
        if ($request->has('payment_method_id')) {
            $paymentMethod = $user->paymentMethods()
                ->where('id', $request->input('payment_method_id'))
                ->firstOrFail();
        }

        $success = $this->paymentService->processInvoicePayment($invoice, $paymentMethod);

        if ($success) {
            return response()->json([
                'message' => 'Payment processed successfully',
                'invoice' => $invoice->fresh(),
            ]);
        }

        return response()->json([
            'error' => 'Payment failed. All payment methods failed.',
        ], 400);
    }

    public function changeSubscription(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:subscription_packages,id',
            'billing_cycle' => 'required|in:monthly,yearly',
            'immediate' => 'boolean',
        ]);

        $user = Auth::user();
        $package = \App\Models\SubscriptionPackage::findOrFail($request->input('package_id'));
        $billingCycle = $request->input('billing_cycle');
        $immediate = $request->boolean('immediate', false);

        try {
            $change = $this->subscriptionChangeService->changeSubscription(
                $user,
                $package,
                $billingCycle,
                $immediate
            );

            return response()->json([
                'message' => 'Subscription change initiated',
                'change' => $change,
                'effective_date' => $change->effective_date,
                'proration_amount' => $change->proration_amount,
            ]);
        } catch (\Exception $e) {
            Log::error('Subscription change failed', [
                'user_id' => $user->id,
                'package_id' => $package->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => 'Failed to change subscription: ' . $e->getMessage(),
            ], 400);
        }
    }

    public function webhookHandler(Request $request, string $processor)
    {
        try {
            $processorInstance = $this->processorRegistry->get($processor);
            $event = $request->header('X-Event-Type') ?? $request->input('event');
            $payload = $request->all();

            Log::info("Webhook received for {$processor}", [
                'event' => $event,
                'payload_keys' => array_keys($payload),
            ]);

            $response = $processorInstance->handleWebhook($event, $payload);

            if ($response->wasHandled()) {
                return response()->json(['status' => 'handled', 'message' => $response->message]);
            }

            return response()->json(['status' => 'ignored'], 200);
        } catch (\Exception $e) {
            Log::error("Webhook handling failed for {$processor}", [
                'error' => $e->getMessage(),
                'payload' => $request->all(),
            ]);

            return response()->json(['error' => 'Webhook handling failed'], 500);
        }
    }

    public function getUserPaymentMethods()
    {
        $user = Auth::user();
        $paymentMethods = $user->paymentMethods()
            ->with([])
            ->orderBy('priority', 'desc')
            ->orderBy('is_default', 'desc')
            ->get();

        return response()->json([
            'payment_methods' => $paymentMethods->map(function ($method) {
                return [
                    'id' => $method->id,
                    'type' => $method->type,
                    'name' => $method->name,
                    'provider' => $method->provider,
                    'is_enabled' => $method->is_enabled,
                    'is_default' => $method->is_default,
                    'priority' => $method->priority,
                    'last_used_at' => $method->last_used_at,
                    'metadata' => $method->metadata,
                ];
            }),
        ]);
    }
}