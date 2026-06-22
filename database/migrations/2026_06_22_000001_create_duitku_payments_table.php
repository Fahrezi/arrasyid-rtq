<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duitku_payments', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_order_id')->unique();
            $table->foreignId('donation_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('reference')->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->text('payment_url')->nullable();
            $table->string('va_number')->nullable();
            $table->text('qr_string')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duitku_payments');
    }
};
