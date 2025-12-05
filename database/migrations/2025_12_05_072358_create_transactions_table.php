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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('order_number')->unique();
            $table->string('buyer_id');
            $table->foreign('buyer_id')->references('id')->on('buyers')->onDelete('cascade');
            $table->string('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->string('food_id');
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['PENDING', 'PAID', 'READY_FOR_PICKUP', 'COMPLETED', 'CANCELLED']);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->enum('payment_method', ['CASH', 'TRANSFER', 'E_WALLET', 'CREDIT_CARD']);
            $table->string('payment_id')->nullable();
            $table->string('payment_proof')->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed']);
            $table->string('pickup_code')->nullable();
            $table->timestamp('pickup_time');
            $table->timestamp('pickup_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
