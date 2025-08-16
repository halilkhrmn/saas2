<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #ffc107; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; }
        .content { margin-bottom: 30px; }
        .invoice-info { background: #fff3cd; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #ffc107; }
        .button { display: inline-block; background: #ffc107; color: #000; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; font-weight: bold; }
        .footer { text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; }
        .highlight { color: #007bff; font-weight: bold; }
        .warning { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <h3 style="color: #ffc107; margin: 10px 0 0 0;">Payment Reminder</h3>
        </div>
        
        <div class="content">
            <h2>Payment Due Soon</h2>
            
            <p>Hello {{ $invoice->user->name }},</p>
            
            <p>This is a friendly reminder that your invoice is due soon. To avoid any service interruption, please complete your payment as soon as possible.</p>
            
            <div class="invoice-info">
                <strong>Invoice Details:</strong><br>
                <span class="highlight">Invoice Number:</span> {{ $invoice->invoice_number }}<br>
                <span class="highlight">Amount:</span> ${{ number_format($invoice->total_amount, 2) }}<br>
                <span class="warning">Due Date:</span> {{ $invoice->due_date->format('F j, Y') }}<br>
                <span class="highlight">Package:</span> {{ $invoice->subscription->package->name }} ({{ ucfirst($invoice->subscription->billing_cycle) }})<br>
                <span class="warning">Days Until Due:</span> {{ now()->diffInDays($invoice->due_date, false) }} days
            </div>
            
            <p><strong>What happens if payment is late?</strong></p>
            <ul>
                <li>Your API access may be temporarily suspended</li>
                <li>Additional late fees may apply</li>
                <li>Service restoration may take time after payment</li>
            </ul>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/subscription/invoice/' . $invoice->id . '/pay') }}" class="button">Pay Now to Avoid Interruption</a>
            </div>
            
            <p>If you've already paid this invoice, please disregard this email. If you're experiencing any issues with payment, please contact our support team immediately.</p>
            
            <p>Best regards,<br>The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>Invoice #{{ $invoice->invoice_number }} | Due: {{ $invoice->due_date->format('M j, Y') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>