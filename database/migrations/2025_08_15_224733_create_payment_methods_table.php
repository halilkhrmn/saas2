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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // PaymentMethodType enum
            $table->string('name'); // User-friendly name like "My Visa Card"
            $table->string('provider')->nullable(); // stripe, paypal, etc.
            $table->string('provider_payment_method_id')->nullable(); // ID from payment provider
            $table->json('metadata')->nullable(); // Store last 4 digits, expiry, etc.
            $table->integer('priority')->default(0); // Higher priority = preferred fallback order
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_enabled']);
            $table->index(['user_id', 'is_default']);
            $table->index(['user_id', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
