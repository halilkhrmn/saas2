<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for subscription and invoice notifications
    |
    */

    'enabled' => env('NOTIFICATIONS_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Invoice Notifications
    |--------------------------------------------------------------------------
    */
    'invoices' => [
        'expiry_warning_days' => (int) env('INVOICE_EXPIRY_WARNING_DAYS', 5),
        'payment_reminder_days' => (int) env('PAYMENT_REMINDER_DAYS', 3),
        'overdue_reminder_days' => (int) env('OVERDUE_REMINDER_DAYS', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Notifications
    |--------------------------------------------------------------------------
    */
    'subscriptions' => [
        'expiry_warning_days' => (int) env('SUBSCRIPTION_EXPIRY_WARNING_DAYS', 7),
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Settings
    |--------------------------------------------------------------------------
    */
    'emails' => [
        'welcome' => env('WELCOME_EMAIL_ENABLED', true),
        'invoice' => env('INVOICE_EMAIL_ENABLED', true),
        'payment_reminder' => env('PAYMENT_REMINDER_EMAIL_ENABLED', true),
    ],
];