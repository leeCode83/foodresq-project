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
        Schema::create('foods', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('seller_id');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['BAKERY', 'RESTAURANT', 'CAFE', 'GROCERY', 'CATERING', 'DESSERT', 'FAST_FOOD', 'OTHER']);
            $table->string('image_url');
            $table->decimal('original_price', 10, 2);
            $table->decimal('discounted_price', 10, 2);
            $table->integer('discount_percentage');
            $table->integer('quantity');
            $table->integer('available_quantity');
            $table->timestamp('pickup_time_start')->nullable();
            $table->timestamp('pickup_time_end')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
