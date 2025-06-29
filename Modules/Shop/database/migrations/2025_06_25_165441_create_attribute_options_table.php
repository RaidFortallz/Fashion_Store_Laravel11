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
        Schema::create('shop_attribute_options', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('attribute_id')->index();
            $table->string('slug');
            $table->string('name');
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')->on('shop_attributes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_attribute_options');
    }
};
