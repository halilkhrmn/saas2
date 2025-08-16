<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription Expired</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border: 2px solid #dc3545; }
        .header { text-align: center; border-bottom: 2px solid #dc3545; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; }
        .expired { background: #dc3545; color: white; padding: 10px; border-radius: 5px; text-align: center; font-weight: bold; margin: 10px 0; }
        .content { margin-bottom: 30px; }
        .subscription-info { background: #f8d7da; padding: 20px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #dc3545; }
        .button { display: inline-block; background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; margin: 10px 0; font-weight: bold; font-size: 16px; }
        .footer { text-align: center; font-size: 12px; color: #666; border-top: 1px solid #eee; padding-top: 20px; margin-top: 30px; }
        .highlight { color: #007bff; font-weight: bold; }
        .danger { color: #dc3545; font-weight: bold; }
        .benefits { background: #d4edda; padding: 20px; border-radius: 5px; border-left: 4px solid #28a745; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <div class="expired">🔒 Subscription Expired</div>
        </div>
        
        <div class="content">
            <h2>Your Subscription Has Expired</h2>
            
            <p>Hello {{ $subscription->user->name }},</p>
            
            <p>Your subscription has expired and your API access has been suspended. To restore your service, please renew your subscription.</p>
            
            <div class="subscription-info">
                <strong>Expired Subscription Details:</strong><br>
                <span class="highlight">Package:</span> {{ $subscription->package->name }}<br>
                <span class="highlight">Billing Cycle:</span> {{ ucfirst($subscription->billing_cycle) }}<br>
                <span class="danger">Expired On:</span> {{ $subscription->end_date->format('F j, Y') }}<br>
                <span class="danger">Days Since Expiry:</span> {{ $subscription->end_date->diffInDays(now()) }} days<br>
                <span class="highlight">Previous Price:</span> ${{ number_format($subscription->package->getPrice($subscription->billing_cycle), 2) }}
            </div>
            
            <p><strong style="color: #dc3545;">Current Status:</strong></p>
            <ul>
                <li>🚫 API access is suspended</li>
                <li>🔑 All API keys are inactive</li>
                <li>📊 Analytics and dashboard access is limited</li>
                <li>💾 Your data is preserved for 30 days</li>
            </ul>
            
            <div class="benefits">
                <strong style="color: #28a745;">Reactivate Now to:</strong>
                <ul style="color: #155724; margin-top: 10px;">
                    <li>✅ Instantly restore API access</li>
                    <li>✅ Reactivate all your existing API keys</li>
                    <li>✅ Resume full dashboard functionality</li>
                    <li>✅ Continue where you left off</li>
                    <li>✅ Preserve your usage history</li>
                </ul>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/pricing') }}" class="button">Reactivate Subscription</a>
            </div>
            
            <p><strong>Important:</strong> If you don't renew within 30 days of expiration, your data may be permanently deleted according to our data retention policy.</p>
            
            <p style="background: #d1ecf1; padding: 15px; border-radius: 5px; border-left: 4px solid #bee5eb;">
                <strong>Questions?</strong> Our support team is ready to help you get back up and running. Contact us if you need assistance choosing the right plan or have any billing questions.
            </p>
            
            <p>We hope to see you back soon!</p>
            
            <p>Best regards,<br>The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>{{ $subscription->package->name }} | Expired: {{ $subscription->end_date->format('M j, Y') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>