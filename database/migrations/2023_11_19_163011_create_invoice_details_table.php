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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id("invoice_detail_id");
            $table->foreignIdFor(\App\Models\Invoice::class, "invoice_id");
            $table->foreignIdFor(\App\Models\Product::class, "product_id");
            $table->integer("quantity");
            $table->float("unit_price");
            $table->float("total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
