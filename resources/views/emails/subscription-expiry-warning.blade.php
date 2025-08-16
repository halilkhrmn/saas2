<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription Expires Soon</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #fd7e14; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; }
        .content { margin-bottom: 30px; }
        .subscription-info { background: #fff3cd; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #fd7e14; }
        .button { display: inline-block; background: #fd7e14; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; font-weight: bold; }
        .footer { text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; }
        .highlight { color: #007bff; font-weight: bold; }
        .warning { color: #fd7e14; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <h3 style="color: #fd7e14; margin: 10px 0 0 0;">⏰ Subscription Expiring Soon</h3>
        </div>
        
        <div class="content">
            <h2>Don't Lose Access to Your API</h2>
            
            <p>Hello {{ $subscription->user->name }},</p>
            
            <p>Your subscription is expiring soon. To ensure uninterrupted access to our API services, please renew your subscription before the expiration date.</p>
            
            <div class="subscription-info">
                <strong>Subscription Details:</strong><br>
                <span class="highlight">Package:</span> {{ $subscription->package->name }}<br>
                <span class="highlight">Billing Cycle:</span> {{ ucfirst($subscription->billing_cycle) }}<br>
                <span class="warning">Expires On:</span> {{ $subscription->end_date->format('F j, Y') }}<br>
                <span class="warning">Days Remaining:</span> {{ now()->diffInDays($subscription->end_date, false) }} days<br>
                <span class="highlight">Current Price:</span> ${{ number_format($subscription->package->getPrice($subscription->billing_cycle), 2) }}
            </div>
            
            <p><strong>What happens if your subscription expires?</strong></p>
            <ul>
                <li>🚫 Your API access will be immediately suspended</li>
                <li>🔑 All your API keys will become inactive</li>
                <li>📊 You'll lose access to your usage analytics</li>
                <li>⏳ You'll need to reactivate and may experience delays</li>
            </ul>
            
            <p><strong>Renew now to:</strong></p>
            <ul style="color: #28a745;">
                <li>✅ Keep your current API keys active</li>
                <li>✅ Maintain uninterrupted service</li>
                <li>✅ Lock in your current pricing</li>
                <li>✅ Continue accessing all features</li>
            </ul>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/pricing') }}" class="button">Renew Subscription Now</a>
            </div>
            
            <p>If you have any questions about your subscription or need assistance with renewal, please don't hesitate to contact our support team.</p>
            
            <p>Best regards,<br>The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>{{ $subscription->package->name }} Subscription | Expires: {{ $subscription->end_date->format('M j, Y') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>