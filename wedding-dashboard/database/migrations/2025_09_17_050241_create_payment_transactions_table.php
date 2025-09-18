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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->string('payment_method_name', 50);
            $table->decimal('provider_admin_fee', 12, 2)->default(0.00);
            $table->decimal('provider_merchant_fee', 12, 2)->default(0.00);
            $table->decimal('admin_fee', 12, 2)->default(0.00);
            $table->decimal('merchant_fee', 12, 2)->default(0.00);
            $table->string('status_code', 20)->nullable();
            $table->string('status_message', 200)->nullable();
            $table->string('payment_other_reff', 200)->nullable();
            $table->timestamps();
            
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};