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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method_name', 100);
            $table->text('description')->nullable();
            $table->decimal('provider_admin_fee', 12, 2)->default(0.00);
            $table->decimal('provider_merchant_fee', 12, 2)->default(0.00);
            $table->decimal('admin_fee', 12, 2)->default(0.00);
            $table->decimal('merchant_fee', 12, 2)->default(0.00);
            $table->string('m_key', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};