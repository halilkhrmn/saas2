<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URGENT: Overdue Payment</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border: 2px solid #dc3545; }
        .header { text-align: center; border-bottom: 2px solid #dc3545; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; }
        .urgent { background: #dc3545; color: white; padding: 10px; border-radius: 5px; text-align: center; font-weight: bold; margin: 10px 0; }
        .content { margin-bottom: 30px; }
        .invoice-info { background: #f8d7da; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #dc3545; }
        .button { display: inline-block; background: #dc3545; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px 0; font-weight: bold; font-size: 16px; }
        .footer { text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; }
        .highlight { color: #007bff; font-weight: bold; }
        .danger { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <div class="urgent">⚠️ URGENT: OVERDUE PAYMENT ⚠️</div>
        </div>
        
        <div class="content">
            <h2 style="color: #dc3545;">Immediate Action Required</h2>
            
            <p>Hello {{ $invoice->user->name }},</p>
            
            <p><strong>Your invoice is now overdue and requires immediate payment to avoid service suspension.</strong></p>
            
            <div class="invoice-info">
                <strong>Overdue Invoice Details:</strong><br>
                <span class="highlight">Invoice Number:</span> {{ $invoice->invoice_number }}<br>
                <span class="highlight">Amount:</span> ${{ number_format($invoice->total_amount, 2) }}<br>
                <span class="danger">Due Date:</span> {{ $invoice->due_date->format('F j, Y') }}<br>
                <span class="highlight">Package:</span> {{ $invoice->subscription->package->name }} ({{ ucfirst($invoice->subscription->billing_cycle) }})<br>
                <span class="danger">Days Overdue:</span> {{ $invoice->due_date->diffInDays(now()) }} days
            </div>
            
            <p><strong style="color: #dc3545;">Immediate Consequences:</strong></p>
            <ul>
                <li>🚫 Your API access has been or will be suspended</li>
                <li>💰 Late fees may have been applied to your account</li>
                <li>📧 Additional collection notices will be sent</li>
                <li>⏰ Account may be closed if payment is not received promptly</li>
            </ul>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/subscription/invoice/' . $invoice->id . '/pay') }}" class="button">PAY NOW TO RESTORE SERVICE</a>
            </div>
            
            <p><strong>To restore your service immediately:</strong></p>
            <ol>
                <li>Click the "Pay Now" button above</li>
                <li>Complete your payment using any available method</li>
                <li>Your service will be restored within minutes of successful payment</li>
            </ol>
            
            <p style="background: #fff3cd; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107;">
                <strong>Need Help?</strong> If you're experiencing financial difficulties or technical issues with payment, please contact our support team immediately. We're here to help find a solution.
            </p>
            
            <p>Urgent regards,<br>The {{ config('app.name') }} Billing Team</p>
        </div>
        
        <div class="footer">
            <p><strong>OVERDUE:</strong> Invoice #{{ $invoice->invoice_number }} | {{ $invoice->due_date->diffInDays(now()) }} days past due</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>