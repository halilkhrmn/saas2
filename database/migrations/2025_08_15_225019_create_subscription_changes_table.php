<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('old_subscription_id')->nullable()->constrained('user_subscriptions')->nullOnDelete();
            $table->foreignId('new_subscription_id')->constrained('user_subscriptions')->cascadeOnDelete();
            $table->string('change_type'); // upgrade, downgrade, change_billing_cycle
            $table->decimal('proration_amount', 10, 2)->nullable();
            $table->decimal('credit_amount', 10, 2)->nullable();
            $table->json('change_details')->nullable(); // Store additional metadata
            $table->timestamp('effective_date');
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->timestamps();

            $table->index(['user_id', 'change_type']);
            $table->index(['effective_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_changes');
    }
};
