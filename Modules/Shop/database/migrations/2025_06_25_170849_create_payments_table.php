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
        Schema::create('shop_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('order_id')->index();
            $table->string('payment_type');
            $table->string('status');
            $table->uuid('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->text('note')->nullable();
            $table->uuid('rejected_by')->nullable();
            $table->datetime('rejected_at')->nullable();
            $table->text('rejection_note')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->json('payloads')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_payments');
    }
};
