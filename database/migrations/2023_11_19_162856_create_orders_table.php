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
        Schema::create('orders', function (Blueprint $table) {
            $table->id("order_id");
            $table->foreignIdFor(\App\Models\Cart::class, "cart_id");
            $table->string("code");
            $table->decimal('total_price', 10, 2);
            $table->decimal('shipping_price')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed','delivered'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
