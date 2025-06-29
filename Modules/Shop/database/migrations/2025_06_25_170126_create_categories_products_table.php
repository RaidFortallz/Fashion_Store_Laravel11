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
        Schema::create('shop_categories_products', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('category_id');

            $table->unique(['product_id', 'category_id']);
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('category_id')->references('id')->on('shop_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_categories_products');
    }
};
