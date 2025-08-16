<?php

namespace App\Console\Commands;

use App\Services\SubscriptionMonitoringService;
use Illuminate\Console\Command;

class MonitorSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor subscriptions and send notifications for expiring subscriptions and overdue invoices';

    /**
     * Execute the console command.
     */
    public function handle(SubscriptionMonitoringService $monitoringService): int
    {
        $this->info('Starting subscription monitoring...');
        
        // Check for expiring subscriptions
        $expiringSubscriptions = $monitoringService->checkExpiringSubscriptions();
        $this->info("Found {$expiringSubscriptions->count()} expiring subscriptions");
        
        // Check for overdue invoices
        $overdueInvoices = $monitoringService->checkOverdueInvoices();
        $this->info("Found {$overdueInvoices->count()} overdue invoices");
        
        // Send payment reminders
        $reminderInvoices = $monitoringService->sendPaymentReminders();
        $this->info("Sent payment reminders for {$reminderInvoices->count()} invoices");
        
        // Process expired subscriptions
        $expiredCount = $monitoringService->processExpiredSubscriptions();
        $this->info("Processed {$expiredCount} expired subscriptions");
        
        $this->info('Subscription monitoring completed successfully!');
        
        return Command::SUCCESS;
    }
}
