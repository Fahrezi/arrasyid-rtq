<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakasir_payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('donation_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('project');
            $table->enum('status', ['pending', 'completed', 'failed', 'expired'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_url')->nullable();
            $table->text('qr_string')->nullable();
            $table->string('va_number')->nullable();
            $table->json('webhook_payload')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakasir_payments');
    }
};
