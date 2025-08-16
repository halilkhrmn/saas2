<?php

namespace App;

enum PaymentMethodType: string
{
    case CreditCard = 'credit_card';
    case DebitCard = 'debit_card';
    case BankTransfer = 'bank_transfer';
    case PayPal = 'paypal';
    case Stripe = 'stripe';
    case Wallet = 'wallet';
    case Cryptocurrency = 'cryptocurrency';

    public function label(): string
    {
        return match ($this) {
            self::CreditCard => 'Credit Card',
            self::DebitCard => 'Debit Card',
            self::BankTransfer => 'Bank Transfer',
            self::PayPal => 'PayPal',
            self::Stripe => 'Stripe',
            self::Wallet => 'Digital Wallet',
            self::Cryptocurrency => 'Cryptocurrency',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::CreditCard => 'Pay with credit card',
            self::DebitCard => 'Pay with debit card',
            self::BankTransfer => 'Direct bank transfer',
            self::PayPal => 'Pay via PayPal',
            self::Stripe => 'Pay via Stripe',
            self::Wallet => 'Pay with digital wallet',
            self::Cryptocurrency => 'Pay with cryptocurrency',
        };
    }
}