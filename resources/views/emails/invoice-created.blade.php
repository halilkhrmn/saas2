<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Invoice is Ready</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #007bff; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; }
        .content { margin-bottom: 30px; }
        .invoice-info { background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .button { display: inline-block; background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .footer { text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; }
        .highlight { color: #007bff; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
        </div>
        
        <div class="content">
            <h2>Your Invoice is Ready</h2>
            
            <p>Hello {{ $invoice->user->name }},</p>
            
            <p>Your invoice has been generated and is ready for payment. Here are the details:</p>
            
            <div class="invoice-info">
                <strong>Invoice Details:</strong><br>
                <span class="highlight">Invoice Number:</span> {{ $invoice->invoice_number }}<br>
                <span class="highlight">Amount:</span> ${{ number_format($invoice->total_amount, 2) }}<br>
                <span class="highlight">Due Date:</span> {{ $invoice->due_date->format('F j, Y') }}<br>
                <span class="highlight">Package:</span> {{ $invoice->subscription->package->name }} ({{ ucfirst($invoice->subscription->billing_cycle) }})<br>
            </div>
            
            <p>To complete your subscription activation, please pay this invoice by clicking the button below:</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/subscription/invoice/' . $invoice->id . '/pay') }}" class="button">Pay Invoice Now</a>
            </div>
            
            <p><strong>Important:</strong> Your subscription will be activated immediately after successful payment.</p>
            
            <p>If you have any questions about this invoice, please contact our support team.</p>
            
            <p>Best regards,<br>The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>Invoice #{{ $invoice->invoice_number }} | Due: {{ $invoice->due_date->format('M j, Y') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>