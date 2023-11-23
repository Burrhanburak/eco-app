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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string("slug")->unique();
            $table->string('sku')->unique();
            $table->string('image', 2048)->nullable();
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->unsignedBigInteger('quantity');
            $table->date('published_at')->nullable();
            $table->enum('type', ['deliverable', 'downloadable'])->default('deliverable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
