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
        Schema::create('shop_products_tags', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('tag_id');

            $table->unique(['product_id', 'tag_id']);
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('tag_id')->references('id')->on('shop_tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products_tags');
    }
};
