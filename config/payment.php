<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Payment Processors Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for different payment processors. Each processor can have
    | its own configuration parameters.
    |
    */

    'processors' => [
        'stripe' => [
            'secret_key' => env('STRIPE_SECRET_KEY', 'sk_test_fake_key'),
            'publishable_key' => env('STRIPE_PUBLISHABLE_KEY', 'pk_test_fake_key'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', 'whsec_fake_secret'),
            'enabled' => env('STRIPE_ENABLED', true),
        ],

        'paypal' => [
            'client_id' => env('PAYPAL_CLIENT_ID', 'fake_client_id'),
            'client_secret' => env('PAYPAL_CLIENT_SECRET', 'fake_client_secret'),
            'environment' => env('PAYPAL_ENVIRONMENT', 'sandbox'), // sandbox or live
            'webhook_id' => env('PAYPAL_WEBHOOK_ID', 'fake_webhook_id'),
            'enabled' => env('PAYPAL_ENABLED', true),
        ],

        'manual' => [
            'bank_account' => env('MANUAL_BANK_ACCOUNT', '1234567890'),
            'bank_name' => env('MANUAL_BANK_NAME', 'Example Bank'),
            'routing_number' => env('MANUAL_ROUTING_NUMBER', '987654321'),
            'enabled' => env('MANUAL_ENABLED', true),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Method Settings
    |--------------------------------------------------------------------------
    |
    | Global settings for payment method behavior
    |
    */

    'settings' => [
        // How many consecutive failures before disabling a payment method
        'failure_threshold' => env('PAYMENT_FAILURE_THRESHOLD', 3),
        
        // Default currency for payments
        'default_currency' => env('PAYMENT_DEFAULT_CURRENCY', 'USD'),
        
        // Timeout for payment processing (in seconds)
        'processing_timeout' => env('PAYMENT_PROCESSING_TIMEOUT', 30),
        
        // Enable/disable payment method fallback
        'enable_fallback' => env('PAYMENT_ENABLE_FALLBACK', true),
        
        // Maximum number of fallback attempts
        'max_fallback_attempts' => env('PAYMENT_MAX_FALLBACK_ATTEMPTS', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for handling payment processor webhooks
    |
    */

    'webhooks' => [
        'verify_signatures' => env('PAYMENT_WEBHOOK_VERIFY_SIGNATURES', true),
        'tolerance' => env('PAYMENT_WEBHOOK_TOLERANCE', 300), // 5 minutes
        'log_all_events' => env('PAYMENT_WEBHOOK_LOG_ALL', false),
    ],
];